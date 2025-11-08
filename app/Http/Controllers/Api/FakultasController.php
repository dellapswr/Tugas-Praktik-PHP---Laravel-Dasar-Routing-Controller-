<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fakultas;

class FakultasController extends Controller
{
    // GET /api/fakultas
    public function index()
    {
        $fakultas = Fakultas::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar semua fakultas',
            'data' => $fakultas
        ], 200);
    }

    // POST /api/fakultas
    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|regex:/^[A-Za-z\s]+$/|unique:fakultas,nama_fakultas',
        ]);

        $fakultas = Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fakultas berhasil ditambahkan.',
            'data' => $fakultas
        ], 201);
    }

    // GET /api/fakultas/{id}
    public function show(Fakultas $fakultas)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail fakultas.',
            'data' => $fakultas
        ], 200);
    }

    // PUT /api/fakultas/{id}
    public function update(Request $request, $id)
{
    $fakultas = Fakultas::find($id);

    if (!$fakultas) {
        return response()->json([
            'success' => false,
            'message' => 'Fakultas tidak ditemukan.',
        ], 404);
    }

    $request->validate([
        'nama_fakultas' => 'required|regex:/^[A-Za-z\s]+$/|unique:fakultas,nama_fakultas,' . $id,
    ]);

    $fakultas->update([
        'nama_fakultas' => $request->nama_fakultas,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Fakultas berhasil diperbarui.',
        'data' => $fakultas,
    ], 200);
}


    // DELETE /api/fakultas/{id}
   public function destroy($id)
{
    $fakultas = Fakultas::find($id);

    if (!$fakultas) {
        return response()->json([
            'success' => false,
            'message' => 'Fakultas tidak ditemukan.'
        ], 404);
    }

    $fakultas->delete();

    return response()->json([
        'success' => true,
        'message' => 'Fakultas berhasil dihapus.'
    ], 200);
}

}
