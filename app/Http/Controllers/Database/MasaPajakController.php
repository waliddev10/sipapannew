<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\MasaPajak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class MasaPajakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(MasaPajak::orderBy('updated_at', 'desc')->get())
                ->addColumn('periode', function ($item) {
                    return str_pad($item->bulan, 2, '0', STR_PAD_LEFT) . ' - ' . Carbon::parse(date("F", mktime(0, 0, 0, $item->bulan, 1)))->monthName;
                })
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('masa-pajak.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></button><button class="btn btn-xs btn-warning" title="Detail" data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('masa-pajak.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></button></div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.database.masa-pajak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.database.masa-pajak.create');
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
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
        ]);

        $data = MasaPajak::create([
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Masa Pajak berhasil ditambah.',
            'masa_pajak' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MasaPajak $masa_pajak)
    {
        return view('pages.database.masa-pajak.show', ['item' => $masa_pajak]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MasaPajak $masa_pajak)
    {
        return view('pages.database.masa-pajak.edit', ['item' => $masa_pajak]);
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
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
        ]);

        $data = MasaPajak::findOrFail($id);
        $data->update($request->only([
            'bulan',
            'tahun'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Masa Pajak berhasil diubah.',
            'masa_pajak' => $data
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
        $data = MasaPajak::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Masa Pajak berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
