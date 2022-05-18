<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\SanksiBunga;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class SanksiBungaController extends Controller
{
    public function get()
    {
        $data = SanksiBunga::orderBy('tgl_berlaku', 'desc')->get();

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Bunga tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = SanksiBunga::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Bunga tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'nilai' => 'required|numeric',
            'hari_min' => 'required|numeric',
            'hari_max' => 'required|numeric',
            'hari_pembagi' => 'required|numeric',
            'tgl_berlaku' => 'required|date',
            'keterangan' => 'required'
        ]);

        $data = SanksiBunga::create([
            'id' => Uuid::uuid4(),
            'nilai' => $request->nilai,
            'hari_min' => $request->hari_min,
            'hari_max' => $request->hari_max,
            'hari_pembagi' => $request->hari_pembagi,
            'tgl_berlaku' => $request->tgl_berlaku,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'message' => 'Sanksi Bunga berhasil ditambah.',
            'sanksi_bunga' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'nilai' => 'sometimes|required|numeric',
            'hari_min' => 'sometimes|required|numeric',
            'hari_max' => 'sometimes|required|numeric',
            'hari_pembagi' => 'sometimes|required|numeric',
            'tgl_berlaku' => 'sometimes|required|date',
            'keterangan' => 'sometimes|required'
        ]);

        $data = SanksiBunga::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Bunga tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'nilai',
            'hari_min',
            'hari_max',
            'hari_pembagi',
            'tgl_berlaku',
            'keterangan'
        ]));

        return response()->json([
            'message' => 'Sanksi Bunga berhasil diubah.',
            'sanksi_bunga' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = SanksiBunga::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Sanksi Bunga tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Sanksi Bunga berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
