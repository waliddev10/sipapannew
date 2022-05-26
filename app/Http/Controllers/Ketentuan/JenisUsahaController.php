<?php

namespace App\Http\Controllers\Ketentuan;

use App\Http\Controllers\Controller;
use App\Models\JenisUsaha;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class JenisUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(JenisUsaha::orderBy('created_at', 'desc')->get())
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('jenis-usaha.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></button><button class="btn btn-xs btn-warning" title="Detail" data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('jenis-usaha.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></button></div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.ketentuan.jenis-usaha.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.ketentuan.jenis-usaha.create');
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

        $data = JenisUsaha::create([
            'nama' => $request->nama
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jenis Usaha berhasil ditambah.',
            'jenis_usaha' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(JenisUsaha $jenis_usaha)
    {
        return view('pages.ketentuan.jenis-usaha.show', ['item' => $jenis_usaha]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisUsaha $jenis_usaha)
    {
        return view('pages.ketentuan.jenis-usaha.edit', ['item' => $jenis_usaha]);
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

        $data = JenisUsaha::findOrFail($id);
        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Jenis Usaha berhasil diubah.',
            'jenis-usaha' => $data
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
        $data = JenisUsaha::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Jenis Usaha berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
