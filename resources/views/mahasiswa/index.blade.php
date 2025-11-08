<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filter --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6 mb-6">
                <form method="GET" action="{{ route('mahasiswa.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="fakultas_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Filter Fakultas</label>
                        <select name="fakultas_id" id="fakultas_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white">
                            <option value="">-- Semua Fakultas --</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}" {{ request('fakultas_id') == $f->id ? 'selected' : '' }}>
                                    {{ $f->nama_fakultas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="prodi_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Filter Program Studi</label>
                        <select name="prodi_id" id="prodi_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white">
                            <option value="">-- Semua Prodi --</option>
                        </select>
                    </div>

                    <div>
                        <label for="nama" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Cari Nama</label>
                        <input type="text" name="nama" id="nama"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white"
                               placeholder="Cari mahasiswa..." value="{{ request('nama') }}">
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tombol Tambah (khusus admin) --}}
            @if(auth()->user()->role === 'admin')
            <div class="flex justify-end mb-4">
                <a href="{{ route('mahasiswa.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                    + Tambah Mahasiswa
                </a>
            </div>
            @endif

            {{-- Tabel --}}
            <div class="flex justify-center">
                <div class="w-full max-w-5xl bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6">

                    <table class="w-full border-collapse text-center">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <th class="py-3 px-4 border">ID</th>
                                <th class="py-3 px-4 border">NIM</th>
                                <th class="py-3 px-4 border">Nama</th>
                                <th class="py-3 px-4 border">Fakultas</th>
                                <th class="py-3 px-4 border">Program Studi</th>
                                <th class="py-3 px-4 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($mahasiswa as $m)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="py-2 border">{{ $m->id }}</td>
                                    <td class="py-2 border">{{ $m->nim }}</td>
                                    <td class="py-2 border">{{ $m->nama }}</td>
                                    <td class="py-2 border">{{ $m->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                                    <td class="py-2 border">{{ $m->prodi->nama_prodi ?? '-' }}</td>
                                    <td class="py-2 border flex justify-center gap-2">
                                        <a href="{{ url('/mahasiswa/'.$m->id.'/nilai') }}" 
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition text-sm">
                                            Nilai
                                        </a>

                                        @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('mahasiswa.edit', $m->id) }}" 
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded transition text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition text-sm">
                                                Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-gray-500 py-4">Belum ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

    {{-- Dropdown Dinamis --}}
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

            if (fakultasSelect.value) {
                await loadProdi(fakultasSelect.value, selectedProdi);
            }

            fakultasSelect.addEventListener('change', e => loadProdi(e.target.value));
        });
    </script>
</x-app-layout>
