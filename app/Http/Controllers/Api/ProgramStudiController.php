<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\Fakultas;

class ProgramStudiController extends Controller
{
    // ===============================
    // INDEX — Tampilkan semua program studi
    // ===============================
    public function index()
    {
        $prodi = ProgramStudi::with('fakultas')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar program studi',
            'data' => $prodi
        ]);
    }

    // ===============================
    // SHOW — Detail satu program studi
    // ===============================
    public function show($id)
    {
        $prodi = ProgramStudi::with('fakultas')->find($id);

        if (!$prodi) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail program studi',
            'data' => $prodi
        ]);
    }

    // ===============================
    // STORE — Tambah program studi
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama_prodi'  => 'required|regex:/^[A-Za-z\s]+$/|unique:prodis,nama_prodi',
        ], [
            'fakultas_id.required' => 'Fakultas wajib dipilih.',
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.regex' => 'Nama prodi hanya boleh huruf dan spasi.',
            'nama_prodi.unique' => 'Nama prodi sudah terdaftar.'
        ]);

        $prodi = ProgramStudi::create([
            'fakultas_id' => $request->fakultas_id,
            'nama_prodi' => $request->nama_prodi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Program studi berhasil ditambahkan.',
            'data' => $prodi
        ], 201);
    }

    // ===============================
    // UPDATE — Ubah data program studi
    // ===============================
    public function update(Request $request, $id)
    {
        $prodi = ProgramStudi::find($id);

        if (!$prodi) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama_prodi'  => 'required|regex:/^[A-Za-z\s]+$/|unique:prodis,nama_prodi,' . $id,
        ]);

        $prodi->update([
            'fakultas_id' => $request->fakultas_id,
            'nama_prodi' => $request->nama_prodi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Program studi berhasil diperbarui.',
            'data' => $prodi
        ]);
    }

    // ===============================
    // DESTROY — Hapus program studi
    // ===============================
    public function destroy($id)
    {
        $prodi = ProgramStudi::find($id);

        if (!$prodi) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi tidak ditemukan'
            ], 404);
        }

        $prodi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Program studi berhasil dihapus.'
        ]);
    }

    // ===============================
    // byFakultas — Ambil prodi berdasarkan fakultas_id
    // ===============================
    public function byFakultas($id)
    {
        $prodi = ProgramStudi::where('fakultas_id', $id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar prodi berdasarkan fakultas',
            'data' => $prodi
        ]);
    }
}
