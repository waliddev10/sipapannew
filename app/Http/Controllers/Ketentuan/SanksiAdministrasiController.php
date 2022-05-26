<?php

namespace App\Http\Controllers\Ketentuan;

use App\Http\Controllers\Controller;
use App\Models\SanksiAdministrasi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class SanksiAdministrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(SanksiAdministrasi::orderBy('created_at', 'desc')->get())
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('sanksi-administrasi.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></button><button class="btn btn-xs btn-warning" title="Detail " data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('sanksi-administrasi.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></button></div>';
                })
                ->editColumn('nilai', function ($item) {
                    return 'Rp ' . number_format($item->nilai, 0, ',', '.');
                })
                ->rawColumns(['action', 'nilai'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.ketentuan.sanksi-administrasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.ketentuan.sanksi-administrasi.create');
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
            'nilai' => 'required|numeric',
            'tgl_batas' => 'required|numeric',
            'hari_min' => 'required|numeric',
            'tgl_berlaku' => 'required|date',
            'keterangan' => 'required'
        ]);

        $data = SanksiAdministrasi::create([
            'nilai' => $request->nilai,
            'tgl_batas' => $request->tgl_batas,
            'hari_min' => $request->hari_min,
            'tgl_berlaku' => $request->tgl_berlaku,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sanksi Administrasi berhasil ditambah.',
            'sanksi_administrasi' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SanksiAdministrasi $sanksi_administrasi)
    {
        return view('pages.ketentuan.sanksi-administrasi.show', ['item' => $sanksi_administrasi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SanksiAdministrasi $sanksi_administrasi)
    {
        return view('pages.ketentuan.sanksi-administrasi.edit', ['item' => $sanksi_administrasi]);
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
            'nilai' => 'sometimes|required|numeric',
            'tgl_batas' => 'sometimes|required|numeric',
            'hari_min' => 'sometimes|required|numeric',
            'tgl_berlaku' => 'sometimes|required|date',
            'keterangan' => 'sometimes|required'
        ]);

        $data = SanksiAdministrasi::findOrFail($id);
        $data->update($request->only([
            'nilai',
            'tgl_batas',
            'hari_min',
            'tgl_berlaku',
            'keterangan',
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Sanksi Administrasi berhasil diubah.',
            'sanksi_administrasi' => $data
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
        $data = SanksiAdministrasi::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sanksi Administrasi berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
