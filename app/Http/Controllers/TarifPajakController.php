<?php

namespace App\Http\Controllers;

use App\Models\TarifPajak;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class TarifPajakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(TarifPajak::orderBy('created_at', 'desc')->get())
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><a class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('tarif-pajak.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></a><a class="btn btn-xs btn-warning" title="Detail " data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('tarif-pajak.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></a></div>';
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.ketentuan.tarif-pajak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.ketentuan.tarif-pajak.create');
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

        $data = TarifPajak::create([
            'id' => Uuid::uuid4(),
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
    public function show(TarifPajak $cara_pelaporan)
    {
        return view('pages.ketentuan.tarif-pajak.show', ['item' => $cara_pelaporan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TarifPajak $cara_pelaporan)
    {
        return view('pages.ketentuan.tarif-pajak.edit', ['item' => $cara_pelaporan]);
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

        $data = TarifPajak::findOrFail($id);
        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Cara Pelaporan berhasil diubah.',
            'tarif-pajak' => $data
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
        $data = TarifPajak::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cara Pelaporan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
