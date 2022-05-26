<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\JenisUsaha;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Perusahaan::orderBy('created_at', 'desc')->get())
                ->addColumn('action', function ($item) {
                    return '<div class="btn-group"><button class="btn btn-xs btn-info" title="Ubah" data-toggle="modal" data-target="#modalContainer" data-title="Ubah" href="' . route('perusahaan.edit', $item->id) . '"> <i class="fas fa-edit fa-fw"></i></button><button class="btn btn-xs btn-warning" title="Detail" data-toggle="modal" data-target="#modalContainer" data-title="Detail" href="' . route('perusahaan.show', $item->id) . '"><i class="fas fa-eye fa-fw"></i></button></div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.database.perusahaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis_usaha = JenisUsaha::all();

        return view('pages.database.perusahaan.create', compact('jenis_usaha'));
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
            'nama' => 'required',
            'alamat' => 'required',
            'tgl_penetapan' => 'required|date',
            'hp_pj' => 'required',
            'nama_pj' => 'required',
            'jenis_usaha_id' => 'required',
            'email' => 'required|email'
        ]);

        $data = Perusahaan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tgl_penetapan' => $request->tgl_penetapan,
            'hp_pj' => $request->hp_pj,
            'nama_pj' => $request->nama_pj,
            'jenis_usaha_id' => $request->jenis_usaha_id,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Perusahaan berhasil ditambah.',
            'perusahaan' => $data
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perusahaan = Perusahaan::with('jenis_usaha')->findOrFail($id);
        return view('pages.database.perusahaan.show', ['item' => $perusahaan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Perusahaan $perusahaan)
    {
        $jenis_usaha = JenisUsaha::all();

        return view('pages.database.perusahaan.edit', ['item' => $perusahaan, 'jenis_usaha' => $jenis_usaha]);
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
            'nama' => 'sometimes|required',
            'alamat' => 'sometimes|required',
            'tgl_penetapan' => 'sometimes|required|date',
            'hp_pj' => 'sometimes|required',
            'nama_pj' => 'sometimes|required',
            'jenis_usaha_id' => 'sometimes|required',
            'email' => 'sometimes|required|email',
        ]);

        $data = Perusahaan::findOrFail($id);
        $data->update($request->only([
            'nama',
            'alamat',
            'tgl_penetapan',
            'hp_pj',
            'nama_pj',
            'jenis_usaha_id',
            'email'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Perusahaan berhasil diubah.',
            'perusahaan' => $data
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
        $data = Perusahaan::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Perusahaan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
