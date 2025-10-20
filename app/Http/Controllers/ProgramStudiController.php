<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\Fakultas;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $prodi = ProgramStudi::with('fakultas')->get();
        return view('prodi.index', compact('prodi'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        return view('prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama_prodi' => ['required', 'regex:/^[A-Za-z\s]+$/']
        ], [
            'fakultas_id.required' => 'Fakultas wajib dipilih.',
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.regex' => 'Nama prodi hanya boleh huruf dan spasi.'
        ]);

        ProgramStudi::create($request->all());
        return redirect('/prodi')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $prodi = ProgramStudi::findOrFail($id);
        $fakultas = Fakultas::all();
        return view('prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama_prodi' => ['required', 'regex:/^[A-Za-z\s]+$/']
        ]);

        $prodi = ProgramStudi::findOrFail($id);
        $prodi->update($request->all());

        return redirect('/prodi')->with('success', 'Program studi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prodi = ProgramStudi::findOrFail($id);
        $prodi->delete();
        return redirect('/prodi')->with('success', 'Program studi berhasil dihapus.');
    }

    // API untuk ambil prodi berdasarkan fakultas (dipakai di form Mahasiswa)
    public function byFakultas($id)
    {
        $prodi = ProgramStudi::where('fakultas_id', $id)->get();
        return response()->json($prodi);
    }
}
