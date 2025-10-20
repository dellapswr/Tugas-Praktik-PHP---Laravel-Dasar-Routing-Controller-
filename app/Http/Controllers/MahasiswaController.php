<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Fakultas;
use App\Models\ProgramStudi;

class MahasiswaController extends Controller
{
    // ===============================
    // INDEX — tampilkan daftar mahasiswa + filter
    // ===============================
    public function index(Request $request)
    {
        $fakultas = Fakultas::all();

        $query = Mahasiswa::with(['prodi.fakultas']);

        // filter fakultas
        if ($request->filled('fakultas_id')) {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('fakultas_id', $request->fakultas_id);
            });
        }

        // filter prodi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // filter nama
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $mahasiswa = $query->get();

        return view('mahasiswa.index', compact('mahasiswa', 'fakultas'));
    }

    // ===============================
    // CREATE — form tambah mahasiswa
    // ===============================
    public function create()
    {
        $fakultas = Fakultas::all();
        return view('mahasiswa.create', compact('fakultas'));
    }

    // ===============================
    // STORE — simpan mahasiswa baru
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nim'        => 'required|digits_between:8,12|regex:/^[0-9]+$/|unique:mahasiswa',
            'nama'       => 'required|regex:/^[A-Za-z\s]+$/',
            'fakultas_id'=> 'required|exists:fakultas,id',
            'prodi_id'   => 'required|exists:prodis,id',
        ], [
            'nim.regex' => 'NIM hanya boleh berisi angka.',
            'nama.regex' => 'Nama hanya boleh huruf dan spasi.',
        ]);

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    // ===============================
    // EDIT — tampilkan form edit
    // ===============================
    public function edit($id)
    {
        $m = Mahasiswa::findOrFail($id);
        $fakultas = Fakultas::all();
        return view('mahasiswa.edit', compact('m', 'fakultas'));
    }

    // ===============================
    // UPDATE — perbarui data mahasiswa
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nim'        => 'required|digits_between:8,12|regex:/^[0-9]+$/|unique:mahasiswa,nim,' . $id,
            'nama'       => 'required|regex:/^[A-Za-z\s]+$/',
            'fakultas_id'=> 'required|exists:fakultas,id',
            'prodi_id'   => 'required|exists:prodis,id',
        ]);

        $m = Mahasiswa::findOrFail($id);
        $m->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    // ===============================
    // DESTROY — hapus data mahasiswa
    // ===============================
    public function destroy($id)
    {
        $m = Mahasiswa::findOrFail($id);
        $m->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
