@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Tambah Fakultas</h2>

    <form action="{{ route('fakultas.store') }}" method="POST" class="p-4 bg-white shadow rounded">
        @csrf
        <div class="mb-3">
            <label for="nama_fakultas" class="form-label">Nama Fakultas</label>
            <input type="text" name="nama_fakultas" id="nama_fakultas"
                   class="form-control @error('nama_fakultas') is-invalid @enderror"
                   value="{{ old('nama_fakultas') }}" pattern="[A-Za-z\s]+" required>
            @error('nama_fakultas') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('fakultas.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
