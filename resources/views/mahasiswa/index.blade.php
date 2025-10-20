@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4 text-dark">Daftar Mahasiswa</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Filter dan Cari --}}
    <div class="card mb-4 p-3 shadow-sm">
        <form method="GET" action="{{ route('mahasiswa.index') }}" class="row g-3 align-items-end">
            {{-- Fakultas --}}
            <div class="col-md-4">
                <label for="fakultas_id" class="form-label">Filter Fakultas</label>
                <select name="fakultas_id" id="fakultas_id" class="form-select">
                    <option value="">-- Semua Fakultas --</option>
                    @foreach($fakultas as $f)
                        <option value="{{ $f->id }}" {{ request('fakultas_id') == $f->id ? 'selected' : '' }}>
                            {{ $f->nama_fakultas }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Program Studi --}}
            <div class="col-md-4">
                <label for="prodi_id" class="form-label">Filter Program Studi</label>
                <select name="prodi_id" id="prodi_id" class="form-select">
                    <option value="">-- Semua Prodi --</option>
                </select>
            </div>

            {{-- Nama Mahasiswa --}}
            <div class="col-md-3">
                <label for="nama" class="form-label">Cari Nama</label>
                <input type="text" name="nama" id="nama" class="form-control"
                       placeholder="Cari mahasiswa..." value="{{ request('nama') }}">
            </div>

            <div class="col-md-1 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>

    {{-- Tombol Tambah --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-success">+ Tambah Mahasiswa</a>
    </div>

    {{-- Tabel Mahasiswa --}}
    <div class="card p-3 shadow-sm">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Fakultas</th>
                    <th>Program Studi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswa as $m)
                    <tr>
                        <td>{{ $m->id }}</td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                        <td>{{ $m->prodi->nama_prodi ?? '-' }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('mahasiswa.edit', $m->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ url('/mahasiswa/'.$m->id.'/nilai') }}" class="btn btn-success btn-sm">Nilai</a>
                            <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">Belum ada data mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script untuk dropdown dinamis fakultas → prodi --}}
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const fakultasSelect = document.getElementById('fakultas_id');
    const prodiSelect = document.getElementById('prodi_id');
    const selectedProdi = "{{ request('prodi_id') }}";

    async function loadProdi(fakultasId, selectedId = null) {
        prodiSelect.innerHTML = '<option>Memuat...</option>';
        if (!fakultasId) {
            prodiSelect.innerHTML = '<option value="">-- Semua Prodi --</option>';
            return;
        }

        const res = await fetch(`/api/fakultas/${fakultasId}/prodi`);
        const data = await res.json();

        prodiSelect.innerHTML = '<option value="">-- Semua Prodi --</option>';
        data.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.nama_prodi;
            if (selectedId && selectedId == p.id) opt.selected = true;
            prodiSelect.appendChild(opt);
        });
    }

    // Load prodi awal (kalau fakultas sudah terpilih)
    if (fakultasSelect.value) {
        await loadProdi(fakultasSelect.value, selectedProdi);
    }

    fakultasSelect.addEventListener('change', e => {
        loadProdi(e.target.value);
    });
});
</script>
@endsection
