<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Models\CaraPelaporan;
use App\Models\KotaPenandatangan;
use App\Models\Pelaporan;
use App\Models\MasaPajak;
use App\Models\Npa;
use App\Models\Penandatangan;
use App\Models\Perusahaan;
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

class PelaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $masa_pajak = MasaPajak::orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
            $perusahaan = Perusahaan::all();
            $sanksi_administrasi = collect(SanksiAdministrasi::all());
            $pelaporan = Pelaporan::all();

            $tgl_libur = TanggalLibur::all();

            $jatuh_tempo = [];
            foreach ($masa_pajak as $mp) {
                foreach ($perusahaan as $p) {

                    // retrieving sanksi admministrasi first from penetapan
                    $sanksi = $sanksi_administrasi
                        ->sortBy([
                            fn ($a, $b) => $b->tgl_berlaku <=> $a->tgl_berlaku
                        ])->first(function ($value, $key) use ($p) {
                            return date($value->tgl_berlaku) <= date($p->tgl_penetapan);
                        });

                    // tgl_jatuh_tempo 
                    $bulan = $mp->bulan + 1; // jatuh tempo di bulan berikutnya dari masa pajak
                    $tgl_jatuh_tempo = date('Y-m-d', mktime(0, 0, 0, $bulan, $sanksi->tgl_batas, $mp->tahun));

                    // mencari tanggal jaatuh tempo,  jika weekend maka ditambah +1 hari
                    while (Carbon::parse($tgl_jatuh_tempo)->isWeekend()) {
                        $tgl_jatuh_tempo = Carbon::parse($tgl_jatuh_tempo)->addDay()->format('Y-m-d');
                    }

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

                    // search pelaporan
                    $pelaporan_check = $pelaporan
                        ->filter(function ($value, $key) use ($mp, $p) {
                            return $value->masa_pajak_id == $mp->id && $value->perusahaan_id == $p->id;
                        });

                    // membuat object
                    $item = (object) [
                        'masa_pajak_id' => $mp->id,
                        'perusahaan_id' => $p->id,
                        'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
                        'hari_min' => $sanksi->hari_min,
                        'tgl_batas_pelaporan' => $tgl_batas_pelaporan,
                        'bulan' => $mp->bulan,
                        'tahun' => $mp->tahun,
                        'nama' => $p->nama,
                        'pelaporan' => $pelaporan_check
                    ];
                    array_push($jatuh_tempo, $item);
                }
            }

            return DataTables::of(collect($jatuh_tempo)->sortBy([
                fn ($a, $b) => $b->tgl_jatuh_tempo <=> $a->tgl_jatuh_tempo,
                fn ($a, $b) => $a->nama <=> $b->nama,
            ]))
                ->addColumn('periode', function ($item) {
                    return str_pad($item->bulan, 2, "0", STR_PAD_LEFT) . '-' . $item->tahun;
                })
                ->addColumn('status', function ($item) {
                    if ($item->pelaporan->count() > 0)
                        return '<div class="btn-group">
                    <a class="btn btn-xs btn-success" title="Cetak Surat Penetapan" data-title="Cetak Surat Penetapan" onclick="return !window.open(this.href, &#039;Surat Penetapan&#039;, &#039;resizable=no,width=1024,height=768&#039;)" href="' . route('pelaporan.cetak-surat', $item->pelaporan->first()->id) . '">
                        <i class="fas fa-print fa-fw"></i>
                    </a>
                    </div>
                    <span class="badge badge-success">Sudah Lapor</span>
                    ';

                    return  '<span class="badge badge-warning">Belum Lapor</span>';
                })
                ->addColumn('keterangan', function ($item) {
                    $diff = Carbon::parse($item->tgl_batas_pelaporan)->diff(now())->days;
                    return  '<small>' . $diff . ' hari lagi</small><br/><small><i class="far fa-clock mr-1"></i>' . $item->hari_min . ' HK</small>';
                })
                ->addColumn('action', function ($item) {
                    if ($item->pelaporan->count() > 0) {
                        return '<div class="btn-group">
                        <button class="btn btn-xs btn-info" title="Lapor Meter" data-toggle="modal" data-target="#modalContainer" data-title="Lapor Meter" disabled>
                            <i class="fas fa-upload fa-fw"></i>
                        </button>
                        <button class="btn btn-xs btn-warning" title="Lihat Pelaporan" data-toggle="modal" data-target="#modalContainer" data-title="Lihat Pelaporan" href="' . route('pelaporan.show', $item->pelaporan->first()->id) . '">
                                <i class="fas fa-eye fa-fw"></i>
                            </button>
                    </div>';
                    }

                    return '<div class="btn-group">
                        <button class="btn btn-xs btn-info" title="Lapor Meter" data-toggle="modal" data-target="#modalContainer" data-title="Lapor Meter" href="' . route('pelaporan.create', [
                        'masa_pajak_id' => $item->masa_pajak_id,
                        'perusahaan_id' => $item->perusahaan_id
                    ]) . '">
                            <i class="fas fa-upload fa-fw"></i>
                        </button>
                        <button disabled class="btn btn-xs btn-warning" title="Lihat Pelaporan" data-title="Lihat Pelaporan" href="">
                                <i class="fas fa-eye fa-fw"></i>
                            </button>
                    </div>';
                })
                ->rawColumns(['action', 'status', 'keterangan'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.penatausahaan.pelaporan.index');
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
        return view('pages.penatausahaan.pelaporan.create', compact('cara_pelaporan', 'masa_pajak_id', 'perusahaan_id', 'penandatangan', 'kota_penandatangan'));
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
        return view('pages.penatausahaan.pelaporan.show', ['item' => $pelaporan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelaporan $pelaporan)
    {
        return view('pages.penatausahaan.pelaporan.edit', ['item' => $pelaporan]);
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

    public function print($id)
    {
        $pelaporan = Pelaporan::with(['masa_pajak', 'perusahaan', 'perusahaan.jenis_usaha', 'cara_pelaporan', 'penandatangan', 'kota_penandatangan'])->findOrFail($id);
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
        $jumlah_pajak_dan_sanksi = $jumlah_pajak_terutang + $nilai_sanksi_administrasi;

        $pdf = PDF::loadView('pdf.surat-penetapan', compact('pelaporan', 'npa', 'tarif_pajak', 'nilai_sanksi_administrasi', 'npa_dokumen', 'jumlah_volume_pemakaian', 'jumlah_pajak_terutang', 'jumlah_pajak_dan_sanksi'));
        return $pdf->stream('download.pdf');
    }

    function showFile($filename)

    {
        $path = storage_path('app/berkas-pelaporan/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = FacadesResponse::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
