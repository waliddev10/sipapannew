<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Npa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class NpaController extends Controller
{
    public function get()
    {
        $data = Npa::with('jenis_usaha')->orderBy('jenis_usaha_id')->orderBy('nilai')->get();

        if (!$data)
            return response()->json([
                'message' => 'NPA tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getOne($id)
    {
        $data = Npa::with('jenis_usaha')->find($id);

        if (!$data)
            return response()->json([
                'message' => 'NPA tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        return response()->json($data, Response::HTTP_OK);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'volume_min' => 'sometimes|required|numeric|nullable',
            'volume_max' => 'sometimes|required|numeric|nullable',
            'nilai' => 'required|numeric',
            'jenis_usaha_id' => 'required',
            'tgl_berlaku' => 'required|date',
            'keterangan' => 'required'
        ]);

        $data = Npa::create([
            'id' => Uuid::uuid4(),
            'volume_min' => $request->volume_min,
            'volume_max' => $request->volume_max,
            'nilai' => $request->nilai,
            'jenis_usaha_id' => $request->jenis_usaha_id,
            'tgl_berlaku' => $request->tgl_berlaku,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'message' => 'NPA berhasil ditambah.',
            'npa' => $data
        ], Response::HTTP_CREATED);
    }

    public function put($id, Request $request)
    {
        $this->validate($request, [
            'volume_min' => 'sometimes|required|numeric|nullable',
            'volume_max' => 'sometimes|required|numeric|nullable',
            'nilai' => 'sometimes|required|numeric',
            'jenis_usaha_id' => 'sometimes|required',
            'tgl_berlaku' => 'sometimes|required|date',
            'keterangan' => 'sometimes|required'
        ]);

        $data = Npa::find($id);

        if (!$data)
            return response()->json([
                'message' => 'NPA tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->update($request->only([
            'volume_min',
            'volume_max',
            'nilai',
            'jenis_usaha_id',
            'tgl_berlaku',
            'keterangan'
        ]));

        return response()->json([
            'message' => 'NPA berhasil diubah.',
            'npa' => $data
        ], Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {
        $data = Npa::find($id);

        if (!$data)
            return response()->json([
                'message' => 'NPA tidak ditemukan.'
            ], Response::HTTP_NOT_FOUND);

        $data->delete();

        return response()->json([
            'message' => 'NPA berhasil dihapus.'
        ], Response::HTTP_ACCEPTED);
    }
}
