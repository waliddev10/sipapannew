<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\KotaPenandatangan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class KotaPenandatanganController extends Controller
{
    public function get()
    {
        $data = KotaPenandatangan::all();

        if (!$data)
            return response()->json([
                'message' => 'Kota penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = KotaPenandatangan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Kota penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);


        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $data = KotaPenandatangan::create([
            'id' => Uuid::uuid4(),
            'nama' => $request->nama
        ]);

        return response()->json([
            'message' => 'Kota penandatangan berhasil ditambah.',
            'kota_penandatangan' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $data = KotaPenandatangan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Kota penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);


        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'message' => 'Kota penandatangan berhasil diubah.',
            'kota_penandatangan' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = KotaPenandatangan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Kota penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Kota penandatangan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
