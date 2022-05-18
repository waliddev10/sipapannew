<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\SanksiAdministrasi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class SanksiAdministrasiController extends Controller
{
    public function get()
    {
        $data = SanksiAdministrasi::orderBy('tgl_berlaku', 'desc')->get();

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Administrasi tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = SanksiAdministrasi::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Administrasi tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'nilai' => 'required|numeric',
            'tgl_batas' => 'required|numeric',
            'hari_min' => 'required|numeric',
            'tgl_berlaku' => 'required|date',
            'keterangan' => 'required'
        ]);

        $data = SanksiAdministrasi::create([
            'id' => Uuid::uuid4(),
            'nilai' => $request->nilai,
            'tgl_batas' => $request->tgl_batas,
            'hari_min' => $request->hari_min,
            'tgl_berlaku' => $request->tgl_berlaku,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'message' => 'Sanksi Administrasi berhasil ditambah.',
            'sanksi_administrasi' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'nilai' => 'sometimes|required|numeric',
            'tgl_batas' => 'sometimes|required|numeric',
            'hari_min' => 'sometimes|required|numeric',
            'tgl_berlaku' => 'sometimes|required|date',
            'keterangan' => 'sometimes|required'
        ]);

        $data = SanksiAdministrasi::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Administrasi tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'nilai',
            'tgl_batas',
            'hari_min',
            'tgl_berlaku',
            'keterangan',
        ]));

        return response()->json([
            'message' => 'Sanksi Administrasi berhasil diubah.',
            'sanksi_administrasi' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = SanksiAdministrasi::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Administrasi tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Sanksi Administrasi berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
