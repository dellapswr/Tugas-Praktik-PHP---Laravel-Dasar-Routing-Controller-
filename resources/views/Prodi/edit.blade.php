@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Edit Program Studi</h2>

    <form action="{{ route('prodi.update', $prodi->id) }}" method="POST" class="p-4 bg-white shadow rounded">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="fakultas_id" class="form-label">Fakultas</label>
            <select name="fakultas_id" id="fakultas_id"
                    class="form-select @error('fakultas_id') is-invalid @enderror" required>
                @foreach($fakultas as $f)
                    <option value="{{ $f->id }}" {{ $prodi->fakultas_id == $f->id ? 'selected' : '' }}>
                        {{ $f->nama_fakultas }}
                    </option>
                @endforeach
            </select>
            @error('fakultas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="nama_prodi" class="form-label">Nama Prodi</label>
            <input type="text" name="nama_prodi" id="nama_prodi"
                   class="form-control @error('nama_prodi') is-invalid @enderror"
                   value="{{ old('nama_prodi', $prodi->nama_prodi) }}" pattern="[A-Za-z\s]+" required>
            @error('nama_prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('prodi.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Perbarui</button>
        </div>
    </form>
</div>
@endsection
