<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\TanggalLibur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class TanggalLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(TanggalLibur::orderBy('created_at', 'desc')->orderBy('tgl_libur', 'asc')->get())
                ->addColumn('hari', function ($item) {
                    $day = Carbon::parse($item->tgl_libur);

                    if ($day->isWeekend()) {
                        return $day->dayName . ' <i class="fas fa-exclamation-circle text-danger"></i>';
                    } else {
                        return $day->dayName;
                    }
                })
                ->addColumn('bulan', function ($item) {
                    return Carbon::parse($item->tgl_libur)->monthName;
                })
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('tanggal-libur.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></butt><button class="btn btn-xs btn-warning" title="Detail" data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('tanggal-libur.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></butt></div>';
                })
                ->rawColumns(['action', 'hari', 'bulan'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.database.tanggal-libur.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.database.tanggal-libur.create');
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
            'tgl_libur' => 'required|date',
            'keterangan' => 'required',
            'dasar_hukum' => 'required',
        ]);

        $data = TanggalLibur::create([
            'tgl_libur' => $request->tgl_libur,
            'keterangan' => $request->keterangan,
            'dasar_hukum' => $request->dasar_hukum
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tanggal Libur berhasil ditambah.',
            'tanggal_libur' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TanggalLibur $tanggal_libur)
    {
        return view('pages.database.tanggal-libur.show', ['item' => $tanggal_libur]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TanggalLibur $tanggal_libur)
    {
        return view('pages.database.tanggal-libur.edit', ['item' => $tanggal_libur]);
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
            'tgl_libur' => 'required|date',
            'keterangan' => 'required',
            'dasar_hukum' => 'required',
        ]);

        $data = TanggalLibur::findOrFail($id);
        $data->update($request->only([
            'tgl_libur',
            'keterangan',
            'dasar_hukum'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Tanggal Libur berhasil diubah.',
            'tanggal_libur' => $data
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
        $data = TanggalLibur::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tanggal Libur berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
