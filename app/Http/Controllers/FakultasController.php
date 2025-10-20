<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;

class FakultasController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::all();
        return view('fakultas.index', compact('fakultas'));
    }

    public function create()
    {
        return view('fakultas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|regex:/^[A-Za-z\s]+$/|unique:fakultas,nama_fakultas',
        ], [
            'nama_fakultas.required' => 'Nama fakultas wajib diisi.',
            'nama_fakultas.regex' => 'Nama fakultas hanya boleh huruf dan spasi.',
            'nama_fakultas.unique' => 'Nama fakultas sudah terdaftar.',
        ]);

        Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas,
        ]);

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Fakultas $fakultas)
    {
        return view('fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, Fakultas $fakultas)
    {
        $request->validate([
            'nama_fakultas' => 'required|regex:/^[A-Za-z\s]+$/|unique:fakultas,nama_fakultas,' . $fakultas->id,
        ], [
            'nama_fakultas.required' => 'Nama fakultas wajib diisi.',
            'nama_fakultas.regex' => 'Nama fakultas hanya boleh huruf dan spasi.',
            'nama_fakultas.unique' => 'Nama fakultas sudah terdaftar.',
        ]);

        $fakultas->update(['nama_fakultas' => $request->nama_fakultas]);

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Fakultas $fakultas)
    {
        $fakultas->delete();
        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil dihapus.');
    }
}
