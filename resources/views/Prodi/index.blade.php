<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tombol Tambah hanya untuk admin --}}
            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end mb-5">
                    <a href="{{ route('prodi.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded shadow transition">
                        + Tambah Program Studi
                    </a>
                </div>
            @endif

            {{-- Tabel --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl p-6">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-center">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <th class="py-3 px-4 border w-20">ID</th>
                                <th class="py-3 px-4 border">Nama Prodi</th>
                                <th class="py-3 px-4 border">Fakultas</th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="py-3 px-4 border w-40">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prodi as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="py-2 border">{{ $p->id }}</td>
                                    <td class="py-2 border">{{ $p->nama_prodi }}</td>
                                    <td class="py-2 border">{{ $p->fakultas->nama_fakultas ?? '-' }}</td>
                                    @if(auth()->user()->role === 'admin')
                                        <td class="py-2 border flex justify-center gap-2">
                                            <a href="{{ route('prodi.edit', $p->id) }}" 
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('prodi.destroy', $p->id) }}" method="POST" 
                                                onsubmit="return confirm('Yakin ingin menghapus program studi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}" class="text-gray-500 py-4">Belum ada data program studi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
