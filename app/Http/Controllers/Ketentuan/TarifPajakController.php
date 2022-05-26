<?php

namespace App\Http\Controllers\Ketentuan;

use App\Http\Controllers\Controller;
use App\Models\TarifPajak;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('tarif-pajak.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></button><button class="btn btn-xs btn-warning" title="Detail " data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('tarif-pajak.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></button></div>';
                })
                ->editColumn('nilai', function ($item) {
                    return $item->nilai * 100 . '%';
                })
                ->rawColumns(['action'])
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
            'nilai' => 'required|numeric',
            'tgl_berlaku' => 'required|date',
            'keterangan' => 'required'
        ]);

        $data = TarifPajak::create([
            'nilai' => $request->nilai / 100,
            'tgl_berlaku' => $request->tgl_berlaku,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tarif Pajak berhasil ditambah.',
            'tarif_pajak' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TarifPajak $tarif_pajak)
    {
        return view('pages.ketentuan.tarif-pajak.show', ['item' => $tarif_pajak]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TarifPajak $tarif_pajak)
    {
        return view('pages.ketentuan.tarif-pajak.edit', ['item' => $tarif_pajak]);
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
            'tgl_berlaku' => 'sometimes|required|date',
            'keterangan' => 'sometimes|required'
        ]);

        $data = TarifPajak::findOrFail($id);
        $data->nilai = $request->nilai / 100;
        $data->tgl_berlaku = $request->tgl_berlaku;
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Tarif Pajak berhasil diubah.',
            'tarif_pajak' => $data
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
            'message' => 'Tarif Pajak berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
