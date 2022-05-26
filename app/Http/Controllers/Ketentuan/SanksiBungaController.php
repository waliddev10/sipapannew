<?php

namespace App\Http\Controllers\Ketentuan;

use App\Http\Controllers\Controller;
use App\Models\SanksiBunga;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class SanksiBungaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(SanksiBunga::orderBy('created_at', 'desc')->get())
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('sanksi-bunga.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></button><button class="btn btn-xs btn-warning" title="Detail " data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('sanksi-bunga.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></button></div>';
                })
                ->editColumn('nilai', function ($item) {
                    return $item->nilai * 100 . '%';
                })
                ->rawColumns(['action', 'nilai'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.ketentuan.sanksi-bunga.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.ketentuan.sanksi-bunga.create');
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
            'hari_min' => 'required|numeric',
            'hari_max' => 'required|numeric',
            'hari_pembagi' => 'required|numeric',
            'tgl_berlaku' => 'required|date',
            'keterangan' => 'required'
        ]);

        $data = SanksiBunga::create([
            'nilai' => $request->nilai / 100,
            'hari_min' => $request->hari_min,
            'hari_max' => $request->hari_max,
            'hari_pembagi' => $request->hari_pembagi,
            'tgl_berlaku' => $request->tgl_berlaku,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sanksi Bunga berhasil ditambah.',
            'sanksi_bunga' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SanksiBunga $sanksi_bunga)
    {
        return view('pages.ketentuan.sanksi-bunga.show', ['item' => $sanksi_bunga]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SanksiBunga $sanksi_bunga)
    {
        return view('pages.ketentuan.sanksi-bunga.edit', ['item' => $sanksi_bunga]);
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
            'hari_min' => 'sometimes|required|numeric',
            'hari_max' => 'sometimes|required|numeric',
            'hari_pembagi' => 'sometimes|required|numeric',
            'tgl_berlaku' => 'sometimes|required|date',
            'keterangan' => 'sometimes|required'
        ]);

        $data = SanksiBunga::findOrFail($id);
        $data->nilai = $request->nilai / 100;
        $data->hari_min = $request->hari_min;
        $data->hari_max = $request->hari_max;
        $data->hari_pembagi = $request->hari_pembagi;
        $data->tgl_berlaku = $request->tgl_berlaku;
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sanksi Bunga berhasil diubah.',
            'sanksi_bunga' => $data
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
        $data = SanksiBunga::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sanksi Bunga berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
