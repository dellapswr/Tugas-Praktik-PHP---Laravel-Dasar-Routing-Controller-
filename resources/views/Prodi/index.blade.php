@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Daftar Program Studi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('prodi.create') }}" class="btn btn-primary">+ Tambah Program Studi</a>
    </div>

    <div class="card p-3 shadow">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Prodi</th>
                    <th>Fakultas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prodi as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nama_prodi }}</td>
                        <td>{{ $p->fakultas->nama_fakultas ?? '-' }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('prodi.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('prodi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus prodi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted">Belum ada data program studi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
