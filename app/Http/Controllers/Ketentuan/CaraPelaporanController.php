<?php

namespace App\Http\Controllers\Ketentuan;

use App\Http\Controllers\Controller;
use App\Models\CaraPelaporan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class CaraPelaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(CaraPelaporan::orderBy('created_at', 'desc')->get())
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('cara-pelaporan.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></button><button class="btn btn-xs btn-warning" title="Detail " data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('cara-pelaporan.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></button></div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.ketentuan.cara-pelaporan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.ketentuan.cara-pelaporan.create');
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

        $data = CaraPelaporan::create([
            'nama' => $request->nama
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cara Pelaporan berhasil ditambah.',
            'cara_pelaporan' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CaraPelaporan $cara_pelaporan)
    {
        return view('pages.ketentuan.cara-pelaporan.show', ['item' => $cara_pelaporan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CaraPelaporan $cara_pelaporan)
    {
        return view('pages.ketentuan.cara-pelaporan.edit', ['item' => $cara_pelaporan]);
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

        $data = CaraPelaporan::findOrFail($id);
        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Cara Pelaporan berhasil diubah.',
            'cara-pelaporan' => $data
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
        $data = CaraPelaporan::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cara Pelaporan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
