<?php

namespace App\Http\Controllers\Penatausahaan;

use App\Http\Controllers\Controller;
use App\Models\CaraPelaporan;
use App\Models\KotaPenandatangan;
use App\Models\MasaPajak;
use App\Models\Pelaporan;
use App\Models\Perusahaan;
use App\Models\SanksiAdministrasi;
use App\Models\TanggalLibur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

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
            // $pelaporan = Pelaporan::all();

            $tgl_libur = TanggalLibur::all();

            $jatuh_tempo = [];
            foreach ($masa_pajak as $mp) {
                foreach ($perusahaan as $p) {
                    $sanksi = $sanksi_administrasi
                        ->sortBy([
                            fn ($a, $b) => $b->tgl_berlaku <=> $a->tgl_berlaku
                        ])->first(function ($value, $key) use ($p) {
                            return date($value->tgl_berlaku) <= date($p->tgl_penetapan);
                        });

                    $tgl_jatuh_tempo = date('Y-m-d', mktime(0, 0, 0, $mp->bulan + 1 /* jatuh tempo di bulan berikutnya dari masa pajak */, $sanksi->tgl_batas, $mp->tahun));


                    while (Carbon::parse($tgl_jatuh_tempo)->isWeekend()) {
                        $tgl_jatuh_tempo = Carbon::parse($tgl_jatuh_tempo)->addDay()->format('Y-m-d');
                    }

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

                    $item = (object) [
                        'masa_pajak_id' => $mp->id,
                        'perusahaan_id' => $p->id,
                        'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
                        'hari_min' => $sanksi->hari_min,
                        'tgl_batas_pelaporan' => $tgl_batas_pelaporan,
                        'bulan' => $mp->bulan,
                        'tahun' => $mp->tahun,
                        'nama' => $p->nama,
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
                    return  '<span class="badge badge-warning">Belum Lapor</span>';
                })
                ->addColumn('keterangan', function ($item) {
                    $diff = Carbon::parse($item->tgl_batas_pelaporan)->diff(now())->days;
                    return  '<small>' . $diff . ' hari lagi</small><br/><small><i class="far fa-clock mr-1"></i>' . $item->hari_min . ' HK</small>';
                })
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><a class="btn btn-xs btn-success" title="Lapor Meter" data-toggle="modal" data-target="#modalContainer" data-title="Lapor Meter" href="' . route('pelaporan.create', [
                        'masa_pajak_id' => $item->masa_pajak_id,
                        'perusahaan_id' => $item->perusahaan_id
                    ]) . '"><i class="fas fa-upload fa-fw"></i></a></div>';
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
        $masa_pajak_id = $request->masa_pajak_id;
        $perusahaan_id = $request->perusahaan_id;
        return view('pages.penatausahaan.pelaporan.create', compact('cara_pelaporan', 'masa_pajak_id', 'perusahaan_id'));
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
            'nama' => 'required'
        ]);

        $data = KotaPenandatangan::create([
            'id' => Uuid::uuid4(),
            'nama' => $request->nama
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pelaporan berhasil ditambah.',
            'kota_penandatangan' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(KotaPenandatangan $kota_penandatangan)
    {
        return view('pages.penatausahaan.pelaporan.show', ['item' => $kota_penandatangan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KotaPenandatangan $kota_penandatangan)
    {
        return view('pages.penatausahaan.pelaporan.edit', ['item' => $kota_penandatangan]);
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

        $data = KotaPenandatangan::findOrFail($id);
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
        $data = KotaPenandatangan::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pelaporan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
