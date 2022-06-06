<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Models\CaraPelaporan;
use App\Models\KotaPenandatangan;
use App\Models\Pelaporan;
use App\Models\Npa;
use App\Models\Penandatangan;
use App\Models\Penetapan;
use App\Models\SanksiAdministrasi;
use App\Models\SanksiBunga;
use App\Models\TanggalLibur;
use App\Models\TarifPajak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response as FacadesResponse;

class PenetapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $data = Pelaporan::with(['perusahaan', 'masa_pajak'])
                ->get();

            $filtered_data = collect($data)
                ->filter(function ($item) use ($request) {
                    if ($request->has('bulan') && $request->bulan != 'Semua') {
                        return $item->masa_pajak->bulan == $request->bulan;
                    } else {
                        return true;
                    }
                })
                ->filter(function ($item) use ($request) {
                    if ($request->has('tahun')) {
                        return $item->masa_pajak->tahun == $request->tahun;
                    } else {
                        return true;
                    }
                });

            $penetapan = Penetapan::all();

            return DataTables::of($filtered_data)
                ->addColumn('periode', function ($item) {
                    return str_pad($item->masa_pajak->bulan, 2, "0", STR_PAD_LEFT) . '-' . $item->masa_pajak->tahun;
                })
                ->editColumn('tgl_pelaporan', function ($item) {
                    return '<span class="float-left">' . $item->tgl_pelaporan . '</span><a class="btn btn-xs btn-success float-right" title="Cetak Surat Penetapan" data-title="Cetak Surat Penetapan" onclick="return !window.open(this.href, &#039;Surat Penetapan&#039;, &#039;resizable=no,width=1024,height=768&#039;)" href="' . route('pelaporan.cetak-surat', $item->id) . '">
                    <i class="fas fa-print fa-xs mr-1"></i><small>Surat Penetapan</small></a>';
                })
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group">
                            <button class="btn btn-xs btn-warning" title="Lihat Daftar Penetapan" data-title="Lihat Daftar Penetapan" href="' . route('penetapan.list', $item->id) . '" data-toggle="modal" data-target="#modalContainer">
                                <i class="fas fa-list fa-fw"></i>
                            </button>
                    </div>';
                })
                ->addColumn('penetapan', function ($item) use ($penetapan) {
                    $penetapan = collect($penetapan)->filter(function ($pen) use ($item) {
                        return $pen->pelaporan_id == $item->id;
                    })->sortBy([
                        fn ($a, $b) => $b->tgl_penetapan <=> $a->tgl_penetapan
                    ]);

                    return '<span class="float-left">' . $penetapan->count() . ' Penetapan</span><span class="float-right"><a class="btn btn-xs btn-success float-right" title="Cetak Surat Penetapan" data-title="Cetak Surat Penetapan" onclick="return !window.open(this.href, &#039;Surat Penetapan&#039;, &#039;resizable=no,width=1024,height=768&#039;)" href="' . route('penetapan.cetak', $penetapan->first()->id) . '">
                    <i class="fas fa-print fa-xs mr-1"></i><small>SKPD Terbaru</small></a></span>';
                })
                ->rawColumns(['action', 'tgl_pelaporan', 'penetapan'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.penatausahaan.penetapan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showList(Request $request, $pelaporan_id)
    {
        if ($request->wantsJson()) {
            $penetapan = Penetapan::with(['pelaporan', 'penandatangan', 'kota_penandatangan'])
                ->where('pelaporan_id', $pelaporan_id)
                ->get();

            return DataTables::of($penetapan)
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group">
                    <a class="btn btn-xs btn-success float-right" title="Cetak SKPD" data-title="Cetak SKPD" onclick="return !window.open(this.href, &#039;SKPD&#039;, &#039;resizable=no,width=1024,height=768&#039;)" href="' . route('penetapan.cetak', $item->id) . '">
                    <i class="fas fa-print fa-fw"></i></a>
                    </div>';
                })
                ->editColumn('no_penetapan', function ($item) {
                    return str_pad($item->no_penetapan, 3, "0", STR_PAD_LEFT);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.penatausahaan.penetapan.showList', [
            'pelaporan_id' => $pelaporan_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cara_pelaporan = CaraPelaporan::all();
        $penandatangan = Penandatangan::all();
        $kota_penandatangan = KotaPenandatangan::all();
        $masa_pajak_id = $request->masa_pajak_id;
        $perusahaan_id = $request->perusahaan_id;
        return view('pages.penatausahaan.penetapan.create', compact('cara_pelaporan', 'masa_pajak_id', 'perusahaan_id', 'penandatangan', 'kota_penandatangan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_pelaporan' => 'required|date',
            'volume' => 'required',
            'cara_pelaporan_id' => 'required',
            'penandatangan_id' => 'required',
            'kota_penandatangan_id' => 'required',
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ]);

        $file = $request->file('file');
        $nama_file = Uuid::uuid4() . "." . $file->extension();
        $tujuan_upload = storage_path('app') . '/berkas-pelaporan';
        $file->move($tujuan_upload, $nama_file);

        $data = Pelaporan::create([
            'masa_pajak_id' => $request->masa_pajak_id,
            'perusahaan_id' => $request->perusahaan_id,
            'tgl_pelaporan' => $request->tgl_pelaporan,
            'volume' => $request->volume,
            'cara_pelaporan_id' => $request->cara_pelaporan_id,
            'penandatangan_id' => $request->penandatangan_id,
            'kota_penandatangan_id' => $request->kota_penandatangan_id,
            'file' => $nama_file,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pelaporan berhasil ditambah.',
            'pelaporan' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelaporan = Pelaporan::with(['cara_pelaporan', 'penandatangan', 'kota_penandatangan'])->findOrFail($id);
        return view('pages.penatausahaan.penetapan.show', ['item' => $pelaporan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelaporan $pelaporan)
    {
        return view('pages.penatausahaan.penetapan.edit', ['item' => $pelaporan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $data = Pelaporan::findOrFail($id);
        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Pelaporan berhasil diubah.',
            'jatuh-tempo' => $data
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pelaporan::findOrFail($id);
        unlink(storage_path('app/berkas-pelaporan/' . $data->file));

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pelaporan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }

    public function print($penetapan_id)
    {
        $penetapan = Penetapan::with(['penandatangan', 'kota_penandatangan'])
            ->findOrFail($penetapan_id);
        $pelaporan = Pelaporan::with(['masa_pajak', 'perusahaan', 'perusahaan.jenis_usaha'])
            ->findOrFail($penetapan->pelaporan_id);
        $npa = Npa::where('jenis_usaha_id', $pelaporan->perusahaan->jenis_usaha_id)
            ->orderBy('nilai', 'asc')
            ->get();

        // retrieving sanksi_admministrasi first from penetapan
        $sanksi_administrasi = SanksiAdministrasi::all()
            ->sortBy([
                fn ($a, $b) => $b->tgl_berlaku <=> $a->tgl_berlaku
            ])->first(function ($value, $key) use ($pelaporan) {
                return date($value->tgl_berlaku) <= date($pelaporan->tgl_pelaporan);
            });

        $tgl_libur = TanggalLibur::all();

        // define var
        $mp = $pelaporan->masa_pajak;
        $sanksi = $sanksi_administrasi;

        // tgl_jatuh_tempo 
        $bulan = $mp->bulan + 1; // jatuh tempo di bulan berikutnya dari masa pajak
        $tgl_jatuh_tempo = date('Y-m-d', mktime(0, 0, 0, $bulan, $sanksi->tgl_batas, $mp->tahun));

        // mencari tanggal jaatuh tempo,  jika weekend maka ditambah +1 hari
        while (Carbon::parse($tgl_jatuh_tempo)->isWeekend()) {
            $tgl_jatuh_tempo = Carbon::parse($tgl_jatuh_tempo)->addDay()->format('Y-m-d');
        }

        /*___MENGHITUNG APAKAH DIKENAKAN SANKSI ADMINISTRASI___*/
        // menghitung kapan batas pelaporan ditambah dengan tanggal libur
        $tgl_batas_pelaporan = $tgl_jatuh_tempo; // init tanggal awal
        $counter_hari = 0;
        $sanksi_hari_counter = $sanksi->hari_min;
        while ($counter_hari < $sanksi_hari_counter) {
            if ($tgl_libur
                ->filter(function ($value, $key) use ($tgl_batas_pelaporan) {
                    return Carbon::parse($value->tgl_libur) == Carbon::parse($tgl_batas_pelaporan);
                })->count()
            ) {
                $sanksi_hari_counter++;
            }
            $tgl_batas_pelaporan = Carbon::parse($tgl_batas_pelaporan)->addWeekday()->format('Y-m-d');
            $counter_hari++;
        }

        if ($tgl_batas_pelaporan < $pelaporan->tgl_pelaporan) {
            $nilai_sanksi_administrasi = $sanksi_administrasi->nilai;
        } else {
            $nilai_sanksi_administrasi = null;
        }

        /*___MENGHITUNG APAKAH DIKENAKAN SANKSI BUNGA___*/
        // retrieving sanksi_admministrasi first from penetapan
        $sanksi_bunga = SanksiBunga::all()
            ->sortBy([
                fn ($a, $b) => $b->tgl_berlaku <=> $a->tgl_berlaku
            ])->first(function ($value, $key) use ($penetapan) {
                return date($value->tgl_berlaku) <= date($penetapan->tgl_penetapan);
            });

        // get penetapan pertama (SKPD pertama)
        $penetapan_pertama = Penetapan::where('pelaporan_id', $penetapan->pelaporan_id)
            ->get()
            ->sortBy([
                fn ($a, $b) => $a->tgl_penetapan <=> $b->tgl_penetapan
            ])->first();

        $perbedaan_hari_dengan_penetapan_pertama = Carbon::parse($penetapan_pertama->tgl_penetapan)
            ->diffInDays(Carbon::parse($penetapan->tgl_penetapan), false);

        // dd($perbedaan_hari_dengan_penetapan_pertama);

        // menghitung kapan batas pembayaran ditambah dengan tanggal libur
        $tgl_batas_penetapan = $penetapan_pertama->tgl_penetapan; // init tanggal awal
        $counter_hari_bunga = 0;
        $sanksi_hari_counter_bunga = $perbedaan_hari_dengan_penetapan_pertama;
        // $sanksi_hari_counter_bunga = $sanksi_bunga->hari_min;
        while ($counter_hari_bunga < $sanksi_hari_counter_bunga) {
            if ($tgl_libur
                ->filter(function ($value, $key) use ($tgl_batas_penetapan) {
                    return Carbon::parse($value->tgl_libur) == Carbon::parse($tgl_batas_penetapan);
                })->count()
            ) {
                $sanksi_hari_counter_bunga++;
            }
            $tgl_batas_penetapan = Carbon::parse($tgl_batas_penetapan)->addWeekday()->format('Y-m-d');
            $counter_hari_bunga++;
        }

        if ($counter_hari_bunga >= $sanksi_bunga->hari_min && $counter_hari_bunga <= $sanksi_bunga->hari_max) {
            $multiplier = ceil($counter_hari_bunga / $sanksi_bunga->hari_pembagi);
            $nilai_sanksi_bunga = $sanksi_bunga->nilai * $multiplier;
        } else {
            $nilai_sanksi_bunga = 0;
        }

        // retrieving tarif_pajak first from penetapan
        $tarif_pajak = TarifPajak::all()
            ->sortBy([
                fn ($a, $b) => $b->tgl_berlaku <=> $a->tgl_berlaku
            ])->first(function ($value, $key) use ($pelaporan) {
                return date($value->tgl_berlaku) <= date($pelaporan->tgl_pelaporan);
            });

        // npa
        $npa_dokumen = [];
        $volume_total = $pelaporan->volume;
        foreach ($npa as $np) {
            // membuat object
            if (!is_null($np->volume_max)) {
                if ($volume_total > $np->volume_max) {
                    if ($np->volume_min == 0) {
                        $volume_pemakaian = $np->volume_max - $np->volume_min;
                    } else {
                        $volume_pemakaian = $np->volume_max - ($np->volume_min - 1);
                    }
                } else {
                    $volume_pemakaian = $volume_total;
                }
            } else {
                $volume_pemakaian = $volume_total;
            }
            $volume_total = $volume_total - $volume_pemakaian;

            // get column volume standar
            if (is_null($np->volume_max)) {
                if ($np->volume_min == 0) {
                    $volume_standar = null;
                } else {
                    $volume_standar = '> ' . ($np->volume_min - 1);
                }
            }
            if (!is_null($np->volume_min) && !is_null($np->volume_max)) {
                $volume_standar = $np->volume_min . ' - ' . $np->volume_max;
            }

            if ($volume_pemakaian > 0) {
                $item = (object) [
                    'volume_standar' => $volume_standar,
                    'volume_pemakaian' =>  $volume_pemakaian,
                    'npa' => $np->nilai,
                    'jumlah' => $volume_pemakaian * $np->nilai,
                    'pajak_terutang' => $volume_pemakaian * $np->nilai * $tarif_pajak->nilai
                ];
                array_push($npa_dokumen, $item);
            }
        }

        // variabel khusus
        $jumlah_volume_pemakaian = collect($npa_dokumen)->sum('volume_pemakaian');
        $jumlah_pajak_terutang = collect($npa_dokumen)->sum('pajak_terutang');
        $jumlah_sanksi_bunga = $nilai_sanksi_bunga * $jumlah_pajak_terutang;
        $jumlah_pajak_dan_sanksi = $jumlah_pajak_terutang + $nilai_sanksi_administrasi + $jumlah_sanksi_bunga;

        $pdf = PDF::loadView('pdf.skpd', compact(
            'penetapan',
            'pelaporan',
            'npa',
            'tarif_pajak',
            'nilai_sanksi_administrasi',
            'nilai_sanksi_bunga',
            'jumlah_sanksi_bunga',
            'npa_dokumen',
            'jumlah_volume_pemakaian',
            'jumlah_pajak_terutang',
            'jumlah_pajak_dan_sanksi'
        ));
        return $pdf->stream('download.pdf');
    }
}
