<?php

namespace App\Http\Controllers;

use App\Models\Npa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class NpaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return
                DataTables::of(
                    Npa::with('jenis_usaha')
                        ->orderBy('jenis_usaha_id', 'asc')
                        ->orderBy('hari_min', 'asc')
                        ->get()
                )
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><a class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('npa.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></a><a class="btn btn-xs btn-warning" title="Detail " data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('npa.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></a></div>';
                })
                ->addColumn('volume', function ($item) {
                    if (is_null($item->volume_min)) return '< ' . $item->volume_max;
                    if (is_null($item->volume_max)) {
                        if ($item->volume_min != 0) return '> ' . ($item->volume_min - 1);
                        return 'Semua';
                    }
                    return $item->volume_min . ' - ' . $item->volume_max;
                })
                ->editColumn('jenis_usaha', function ($item) {
                    if (!empty($item->jenis_usaha)) {
                        return $item->jenis_usaha->nama;
                    }
                    return null;
                })
                ->editColumn('nilai', function ($item) {
                    return number_format($item->nilai, 0, ',', '.');
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.ketentuan.npa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.ketentuan.npa.create');
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

        $data = Npa::create([
            'id' => Uuid::uuid4(),
            'nama' => $request->nama
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'NPA berhasil ditambah.',
            'npa' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Npa $npa)
    {
        return view('pages.ketentuan.npa.show', ['item' => $npa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Npa $npa)
    {
        return view('pages.ketentuan.npa.edit', ['item' => $npa]);
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

        $data = Npa::findOrFail($id);
        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'NPA berhasil diubah.',
            'npa' => $data
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
        $data = Npa::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'NPA berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
