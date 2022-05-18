<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\CaraPelaporan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class CaraPelaporanController extends Controller
{
    public function get()
    {
        $data = CaraPelaporan::all();

        if (!$data)
            return response()->json([
                'message' => 'Cara pelaporan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = CaraPelaporan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Cara pelaporan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $data = CaraPelaporan::create([
            'id' => Uuid::uuid4(),
            'nama' => $request->nama
        ]);

        return response()->json([
            'message' => 'Cara pelaporan berhasil ditambah.',
            'cara_pelaporan' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $data = CaraPelaporan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Cara pelaporan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'nama'
        ]));

        return response()->json([
            'message' => 'Cara pelaporan berhasil diubah.',
            'cara_pelaporan' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = CaraPelaporan::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Cara pelaporan tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Cara pelaporan berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
