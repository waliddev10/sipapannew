<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class PerusahaanController extends Controller
{
    public function get()
    {
        $data = Perusahaan::all();

        if (!$data)
            return response()->json([
                'message' => 'Perusahaan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = Perusahaan::with('jenis_usaha')->find($id);

        if (!$data)
            return response()->json([
                'message' => 'Perusahaan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
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
            'id' => Uuid::uuid4(),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tgl_penetapan' => $request->tgl_penetapan,
            'hp_pj' => $request->hp_pj,
            'nama_pj' => $request->nama_pj,
            'jenis_usaha_id' => $request->jenis_usaha_id,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Perusahaan berhasil ditambah.',
            'perusahaan' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
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

        $data = Perusahaan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Perusahaan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'nama',
            'alamat',
            'tgl_penetapan',
            'hp_pj',
            'nama_pj',
            'jenis_usaha_id'
        ]));

        return response()->json([
            'message' => 'Perusahaan berhasil diubah.',
            'perusahaan' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = Perusahaan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Perusahaan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Perusahaan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
