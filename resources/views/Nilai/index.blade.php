@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">📋 Daftar Nilai Mahasiswa</h2>

    {{-- Alert messages --}}
    @if (session('success'))
        <div class="alert alert-success text-center fw-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center fw-semibold shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Data Mahasiswa --}}
    <div class="card shadow-sm p-4 mb-4 border-0">
        <h5 class="mb-0 lh-lg">
            <strong>Nama:</strong> {{ is_array($mhs) ? $mhs['nama'] : $mhs->nama }} <br>
            <strong>NIM:</strong> {{ is_array($mhs) ? $mhs['nim'] : $mhs->nim }} <br>
            <strong>Program Studi:</strong>
            @if(is_array($mhs))
                {{ is_array($mhs['prodi']) ? ($mhs['prodi']['nama_prodi'] ?? '-') : ($mhs['prodi'] ?? '-') }}
            @else
                {{ $mhs->prodi->nama_prodi ?? '-' }}
            @endif
        </h5>
    </div>

    {{-- Tombol navigasi --}}
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url('/mahasiswa') }}" class="btn btn-secondary px-4">
            ← Kembali
        </a>
        <a href="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/create') }}" 
           class="btn btn-primary px-4">
            + Tambah Nilai
        </a>
    </div>

    {{-- Tabel Nilai --}}
    <div class="card p-3 shadow border-0">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 30%">Mata Kuliah</th>
                    <th style="width: 10%">SKS</th>
                    <th style="width: 15%">Nilai Angka</th>
                    <th style="width: 15%">Nilai Huruf</th>
                    <th style="width: 25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nilai as $n)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ is_array($n) ? $n['mata_kuliah'] : $n->mata_kuliah }}</td>
                        <td>{{ is_array($n) ? $n['sks'] : $n->sks }}</td>
                        <td>{{ is_array($n) ? $n['nilai_angka'] : $n->nilai_angka }}</td>
                        <td>{{ is_array($n) ? $n['nilai_huruf'] : $n->nilai_huruf }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/' . (is_array($n) ? $n['id'] : $n->id) . '/edit') }}" 
                               class="btn btn-warning btn-sm px-3 shadow-sm">
                                ✏️ Edit
                            </a>
                            <form action="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/' . (is_array($n) ? $n['id'] : $n->id)) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted py-3">
                            Belum ada nilai mahasiswa ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
