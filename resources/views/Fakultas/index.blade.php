@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Daftar Fakultas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('fakultas.create') }}" class="btn btn-primary">+ Tambah Fakultas</a>
    </div>

    <div class="card p-3 shadow">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Fakultas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fakultas as $f)
                    <tr>
                        <td>{{ $f->id }}</td>
                        <td>{{ $f->nama_fakultas }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('fakultas.edit', $f->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('fakultas.destroy', $f->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus fakultas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted">Belum ada data fakultas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
