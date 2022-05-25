<?php

namespace App\Http\Controllers\Pelaporan;

use App\Http\Controllers\Controller;
use App\Models\CaraPelaporan;
use App\Models\KotaPenandatangan;
use App\Models\MasaPajak;
use App\Models\Pelaporan;
use App\Models\Perusahaan;
use App\Models\SanksiAdministrasi;
use App\Models\TanggalLibur;
use App\Models\TarifPajak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class JatuhTempoController extends Controller
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

                    $tgl_jatuh_tempo = date('Y-m-d', mktime(0, 0, 0, $mp->bulan, $sanksi->tgl_batas, $mp->tahun));

                    $tgl_libur_masa_pajak_count = $tgl_libur
                        ->filter(function ($value, $key) use ($tgl_jatuh_tempo, $sanksi) {
                            return Carbon::parse($value->tgl_libur) <= Carbon::parse($tgl_jatuh_tempo)->addDays($sanksi->hari_min) && Carbon::parse($tgl_jatuh_tempo)->dayOfWeek != 0 && Carbon::parse($tgl_jatuh_tempo)->dayOfWeek != 6;
                        })->count();

                    $tgl_pelaporan_max  = Carbon::parse($tgl_jatuh_tempo)->addDays($tgl_libur_masa_pajak_count + $sanksi->hari_min)->format('Y-m-d');

                    $item = (object) [
                        'masa_pajak_id' => $mp->id,
                        'perusahaan_id' => $p->id,
                        'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
                        'hari_min' => $sanksi->hari_min,
                        'tgl_pelaporan_max' => $tgl_pelaporan_max,
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
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><a class="btn btn-xs btn-success" title="Lapor Meter" data-toggle="modal" data-target="#modalContainer" data-title="Lapor Meter" href="' . route('jatuh-tempo.create', [
                        'masa_pajak_id' => $item->masa_pajak_id,
                        'perusahaan_id' => $item->perusahaan_id
                    ]) . '"><i class="fas fa-upload fa-fw"></i></a></div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.pelaporan.jatuh-tempo.index');
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
        return view('pages.pelaporan.jatuh-tempo.create', compact('cara_pelaporan', 'masa_pajak_id', 'perusahaan_id'));
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
            'message' => 'Kota Penandatangan berhasil ditambah.',
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
        return view('pages.pelaporan.jatuh-tempo.show', ['item' => $kota_penandatangan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KotaPenandatangan $kota_penandatangan)
    {
        return view('pages.pelaporan.jatuh-tempo.edit', ['item' => $kota_penandatangan]);
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
            'message' => 'Kota Penandatangan berhasil diubah.',
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
            'message' => 'Kota Penandatangan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
