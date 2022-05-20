<?php

namespace App\Http\Controllers;

use App\Models\KotaPenandatangan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class KotaPenandatanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(KotaPenandatangan::orderBy('updated_at', 'desc')->get())
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><a class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('kota-penandatangan.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></a><a class="btn btn-xs btn-warning" title="Detail" data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('kota-penandatangan.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></a></div>';
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.setting.kota-penandatangan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.setting.kota-penandatangan.create');
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
        return view('pages.setting.kota-penandatangan.show', ['item' => $kota_penandatangan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KotaPenandatangan $kota_penandatangan)
    {
        return view('pages.setting.kota-penandatangan.edit', ['item' => $kota_penandatangan]);
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
            'kota-penandatangan' => $data
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
