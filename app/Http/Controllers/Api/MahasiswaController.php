<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Fakultas;
use App\Models\ProgramStudi;

class MahasiswaController extends Controller
{
    // ===============================
    // INDEX — Tampilkan semua mahasiswa + filter
    // ===============================
    public function index(Request $request)
    {
        $query = Mahasiswa::with(['prodi.fakultas']);

        if ($request->filled('fakultas_id')) {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('fakultas_id', $request->fakultas_id);
            });
        }

        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $mahasiswa = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar mahasiswa',
            'data' => $mahasiswa
        ]);
    }

    // ===============================
    // SHOW — Detail mahasiswa + relasi
    // ===============================
    public function show($id)
    {
        $mhs = Mahasiswa::with(['prodi.fakultas', 'nilai'])->find($id);

        if (!$mhs) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail mahasiswa',
            'data' => $mhs
        ]);
    }

    // ===============================
    // STORE — Tambah data mahasiswa
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nim'         => 'required|digits_between:8,12|regex:/^[0-9]+$/|unique:mahasiswa',
            'nama'        => 'required|regex:/^[A-Za-z\s]+$/',
            'fakultas_id' => 'required|exists:fakultas,id',
            'prodi_id'    => 'required|exists:prodis,id',
        ]);

        $mhs = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil ditambahkan.',
            'data' => $mhs
        ], 201);
    }

    // ===============================
    // UPDATE — Perbarui data mahasiswa
    // ===============================
    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::find($id);

        if (!$mhs) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nim'         => 'required|digits_between:8,12|regex:/^[0-9]+$/|unique:mahasiswa,nim,' . $id,
            'nama'        => 'required|regex:/^[A-Za-z\s]+$/',
            'fakultas_id' => 'required|exists:fakultas,id',
            'prodi_id'    => 'required|exists:prodis,id',
        ]);

        $mhs->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil diperbarui.',
            'data' => $mhs
        ]);
    }

    // ===============================
    // DESTROY — Hapus mahasiswa
    // ===============================
    public function destroy($id)
    {
        $mhs = Mahasiswa::find($id);

        if (!$mhs) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $mhs->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil dihapus.'
        ]);
    }
}
