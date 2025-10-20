@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Tambah Mahasiswa</h2>

    <form action="{{ url('/mahasiswa') }}" method="POST" class="p-4 bg-white shadow rounded">
        @csrf

        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" 
                   class="form-control @error('nim') is-invalid @enderror" 
                   id="nim" name="nim" value="{{ old('nim') }}" 
                   pattern="[0-9]+" minlength="8" maxlength="12" required>
            @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" 
                   class="form-control @error('nama') is-invalid @enderror" 
                   id="nama" name="nama" value="{{ old('nama') }}" 
                   pattern="[A-Za-z\s]+" required>
            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Fakultas -->
        <div class="mb-3">
            <label for="fakultas_id" class="form-label">Fakultas</label>
            <select name="fakultas_id" id="fakultas_id" 
                    class="form-select @error('fakultas_id') is-invalid @enderror" required>
                <option value="">-- Pilih Fakultas --</option>
                @foreach($fakultas as $f)
                    <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                @endforeach
            </select>
            @error('fakultas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Program Studi -->
        <div class="mb-3">
            <label for="prodi_id" class="form-label">Program Studi</label>
            <select name="prodi_id" id="prodi_id" 
                    class="form-select @error('prodi_id') is-invalid @enderror" required>
                <option value="">-- Pilih Prodi --</option>
            </select>
            @error('prodi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ url('/mahasiswa') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fakultasSelect = document.getElementById('fakultas_id');
    const prodiSelect = document.getElementById('prodi_id');

    fakultasSelect.addEventListener('change', async function () {
        const fakultasId = this.value;
        prodiSelect.innerHTML = '<option value="">Memuat...</option>';

        if (fakultasId) {
            const res = await fetch(`/api/fakultas/${fakultasId}/prodi`);
            const data = await res.json();

            prodiSelect.innerHTML = '<option value="">-- Pilih Prodi --</option>';
            data.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = p.nama_prodi;
                prodiSelect.appendChild(opt);
            });
        } else {
            prodiSelect.innerHTML = '<option value="">-- Pilih Prodi --</option>';
        }
    });
});
</script>
@endsection
