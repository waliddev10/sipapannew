<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Penandatangan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class PenandatanganController extends Controller
{
    public function get()
    {
        $data = Penandatangan::all();

        if (!$data)
            return response()->json([
                'message' => 'Penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = Penandatangan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'jabatan' => 'required',
            'nip' => 'required',
        ]);

        $data = Penandatangan::create([
            'id' => Uuid::uuid4(),
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nip' => $request->nip
        ]);

        return response()->json([
            'message' => 'Penandatangan berhasil ditambah.',
            'penandatangan' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'sometimes|required',
            'jabatan' => 'sometimes|required',
            'nip' => 'sometimes|required'
        ]);

        $data = Penandatangan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'nama',
            'jabatan',
            'nip'
        ]));

        return response()->json([
            'message' => 'Penandatangan berhasil diubah.',
            'penandatangan' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = Penandatangan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Penandatangan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Penandatangan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
