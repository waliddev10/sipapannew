<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\MasaPajak;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class MasaPajakController extends Controller
{
    public function get()
    {
        $data = MasaPajak::all();

        if (!$data)
            return response()->json([
                'message' => 'Masa pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = MasaPajak::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Masa pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric'
        ]);

        $data = MasaPajak::create([
            'id' => Uuid::uuid4(),
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);

        return response()->json([
            'message' => 'Masa pajak berhasil ditambah.',
            'masa_pajak' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'bulan' => 'sometimes|required|numeric',
            'tahun' => 'sometimes|required|numeric'
        ]);

        $data = MasaPajak::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Masa pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'bulan',
            'tahun'
        ]));

        return response()->json([
            'message' => 'Masa pajak berhasil diubah.',
            'masa_pajak' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = MasaPajak::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Masa pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Masa pajak berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
