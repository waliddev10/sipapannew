<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class HariLiburController extends Controller
{
    public function get()
    {
        $data = HariLibur::orderBy('tgl_libur')->get();

        if (!$data)
            return response()->json([
                'message' => 'Hari libur tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = HariLibur::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Hari libur tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'tgl_libur' => 'date|required',
            'dasar_hukum' => 'required',
            'keterangan' => 'required'
        ]);

        $data = HariLibur::create([
            'id' => Uuid::uuid4(),
            'tgl_libur' => $request->tgl_libur,
            'dasar_hukum' => $request->dasar_hukum,
            'keterangan' => $request->keterangan
        ]);

        return response()->json([
            'message' => 'Hari libur berhasil ditambah.',
            'hari_libur' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'tgl_libur' => 'date|sometimes|required',
            'dasar_hukum' => 'sometimes|required',
            'keterangan' => 'sometimes|required'
        ]);

        $data = HariLibur::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Hari libur tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'tgl_libur',
            'dasar_hukum',
            'keterangan'
        ]));

        return response()->json([
            'message' => 'Hari libur berhasil diubah.',
            'hari_libur' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = HariLibur::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Hari libur tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Hari libur berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
