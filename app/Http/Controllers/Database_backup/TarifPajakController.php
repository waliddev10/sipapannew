<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\TarifPajak;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class TarifPajakController extends Controller
{
    public function get()
    {
        $data = TarifPajak::all();

        if (!$data)
            return response()->json([
                'message' => 'Tarif pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = TarifPajak::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Tarif pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'nilai' => 'required|numeric',
            'tgl_berlaku' => 'required|date',
            'keterangan' => 'required'
        ]);

        $data = TarifPajak::create([
            'id' => Uuid::uuid4(),
            'nilai' => $request->nilai,
            'tgl_berlaku' => $request->tgl_berlaku,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'message' => 'Tarif pajak berhasil ditambah.',
            'tarif_pajak' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'nilai' => 'sometimes|required|numeric',
            'tgl_berlaku' => 'sometimes|required|date',
            'keterangan' => 'sometimes|required'
        ]);

        $data = TarifPajak::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Tarif pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'nilai',
            'tgl_berlaku',
            'keterangan'
        ]));

        return response()->json([
            'message' => 'Tarif pajak berhasil diubah.',
            'tarif_pajak' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = TarifPajak::find($id);

        if (!$data)
            return response()->json([
                'message' => 'Tarif pajak tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'Tarif pajak berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
