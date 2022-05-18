<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\JenisUsaha;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class JenisUsahaController extends Controller
{
    public function get()
    {
        $data = JenisUsaha::all();

        if (!$data)
            return response()->json([
                'message' => 'Jenis usaha tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = JenisUsaha::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Jenis usaha tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $data = JenisUsaha::create([
            'id' => Uuid::uuid4(),
            'nama' => $request->nama
        ]);

        return response()->json([
            'message' => 'Jenis usaha berhasil ditambah.',
            'jenis_usaha' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $data = JenisUsaha::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Jenis usaha tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'message' => 'Jenis usaha berhasil diubah.',
            'jenis_usaha' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = JenisUsaha::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Jenis usaha tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Jenis usaha berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
