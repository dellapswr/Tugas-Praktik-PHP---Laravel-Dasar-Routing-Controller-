<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Nilai;

class NilaiController extends Controller
{
    // ✅ Tambahan biar route /mahasiswa/{id}/nilai bisa jalan
    public function showByMahasiswa($id)
    {
        $mhs = Mahasiswa::with('nilai')->findOrFail($id);
        $nilai = $mhs->nilai; // ambil semua nilai milik mahasiswa
        return view('nilai.index', compact('mhs', 'nilai'));
    }

    public function index($mahasiswa_id)
    {
        $mhs = Mahasiswa::findOrFail($mahasiswa_id);
        $nilai = $mhs->nilai()->orderBy('id')->get();
        return view('nilai.index', compact('mhs','nilai'));
    }

    public function create($mahasiswa_id)
    {
        $mhs = Mahasiswa::findOrFail($mahasiswa_id);
        return view('nilai.create', compact('mhs'));
    }

    public function store(Request $request, $mahasiswa_id)
    {
        $request->validate([
            'mata_kuliah' => ['required','regex:/^[A-Za-z\s]+$/'],
            'sks' => ['required','integer','min:1','max:4'],
            'nilai_angka' => ['required','numeric','between:0,4'],
        ], [
            'mata_kuliah.regex' => 'Mata Kuliah hanya boleh huruf dan spasi.',
            'sks.integer' => 'SKS harus angka bulat.',
            'sks.min' => 'Minimal 1 SKS.',
            'sks.max' => 'Maksimal 4 SKS.',
            'nilai_angka.between' => 'Nilai angka harus antara 0 sampai 4.',
        ]);

        // konversi nilai huruf
        $angka = floatval($request->nilai_angka);
        if ($angka >= 3.5) $huruf = 'A';
        elseif ($angka >= 3.0) $huruf = 'B';
        elseif ($angka >= 2.0) $huruf = 'C';
        elseif ($angka >= 1.0) $huruf = 'D';
        else $huruf = 'E';

        Nilai::create([
            'mahasiswa_id' => $mahasiswa_id,
            'mata_kuliah' => $request->mata_kuliah,
            'sks' => $request->sks,
            'nilai_angka' => $angka,
            'nilai_huruf' => $huruf,
        ]);

        return redirect("/mahasiswa/{$mahasiswa_id}/nilai")->with('success','Nilai berhasil ditambahkan.');
    }

    public function edit($mahasiswa_id, $id)
    {
        $mhs = Mahasiswa::findOrFail($mahasiswa_id);
        $n = Nilai::where('mahasiswa_id',$mahasiswa_id)->findOrFail($id);
        return view('nilai.edit', compact('mhs','n'));
    }

    public function update(Request $request, $mahasiswa_id, $id)
    {
        $request->validate([
            'mata_kuliah' => ['required','regex:/^[A-Za-z\s]+$/'],
            'sks' => ['required','integer','min:1','max:4'],
            'nilai_angka' => ['required','numeric','between:0,4'],
        ]);

        $n = Nilai::where('mahasiswa_id',$mahasiswa_id)->findOrFail($id);

        $angka = floatval($request->nilai_angka);
        if ($angka >= 3.5) $huruf = 'A';
        elseif ($angka >= 3.0) $huruf = 'B';
        elseif ($angka >= 2.0) $huruf = 'C';
        elseif ($angka >= 1.0) $huruf = 'D';
        else $huruf = 'E';

        $n->update([
            'mata_kuliah' => $request->mata_kuliah,
            'sks' => $request->sks,
            'nilai_angka' => $angka,
            'nilai_huruf' => $huruf,
        ]);

        return redirect("/mahasiswa/{$mahasiswa_id}/nilai")->with('success','Nilai berhasil diperbarui.');
    }

    public function destroy($mahasiswa_id, $id)
    {
        $n = Nilai::where('mahasiswa_id',$mahasiswa_id)->findOrFail($id);
        $n->delete();
        return redirect("/mahasiswa/{$mahasiswa_id}/nilai")->with('success','Nilai berhasil dihapus.');
    }
}
