@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Edit Nilai</h2>

    <div class="card shadow-sm p-4 mb-4 border-0">
        <h5 class="mb-0">
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

    <form action="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/' . (is_array($n) ? $n['id'] : $n->id)) }}"
          method="POST"
          class="p-4 bg-white shadow rounded border-0">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Mata Kuliah</label>
            <input type="text" name="mata_kuliah"
                   class="form-control @error('mata_kuliah') is-invalid @enderror"
                   value="{{ old('mata_kuliah', is_array($n) ? $n['mata_kuliah'] : $n->mata_kuliah) }}"
                   pattern="[A-Za-z\s]+" required>
            @error('mata_kuliah') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">SKS</label>
            <input type="number" name="sks"
                   class="form-control @error('sks') is-invalid @enderror"
                   min="1" max="6"
                   value="{{ old('sks', is_array($n) ? $n['sks'] : $n->sks) }}" required>
            @error('sks') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nilai Angka</label>
            <input type="number" name="nilai_angka"
                   class="form-control @error('nilai_angka') is-invalid @enderror"
                   step="0.01" min="0" max="4"
                   value="{{ old('nilai_angka', is_array($n) ? $n['nilai_angka'] : $n->nilai_angka) }}" required>
            @error('nilai_angka') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nilai Huruf</label>
            <input type="text" name="nilai_huruf" class="form-control bg-light" readonly
                   value="{{ old('nilai_huruf', is_array($n) ? $n['nilai_huruf'] : $n->nilai_huruf) }}">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai') }}"
               class="btn btn-secondary px-4">
               ← Kembali
            </a>
            <button type="submit" class="btn btn-primary px-4">
                Update Nilai
            </button>
        </div>
    </form>
</div>
@endsection
