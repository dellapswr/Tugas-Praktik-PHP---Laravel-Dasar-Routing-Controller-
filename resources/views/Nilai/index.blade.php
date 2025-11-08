<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Nilai Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center shadow">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Info Mahasiswa --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl p-6 mb-6 text-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-lg mb-2">
                    {{ is_array($mhs) ? $mhs['nama'] : $mhs->nama }}
                    <span class="text-gray-500 text-sm">({{ is_array($mhs) ? $mhs['nim'] : $mhs->nim }})</span>
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    <strong>Program Studi:</strong>
                    @if(is_array($mhs))
                        {{ is_array($mhs['prodi']) ? ($mhs['prodi']['nama_prodi'] ?? '-') : ($mhs['prodi'] ?? '-') }}
                    @else
                        {{ $mhs->prodi->nama_prodi ?? '-' }}
                    @endif
                </p>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center mb-5">
                <a href="{{ url('/mahasiswa') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow transition">
                    ← Kembali
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                    + Tambah Nilai
                </a>
                @endif
            </div>

            {{-- Tabel Nilai --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl p-6">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-center">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <th class="py-3 px-4 border w-16">No</th>
                                <th class="py-3 px-4 border">Mata Kuliah</th>
                                <th class="py-3 px-4 border w-20">SKS</th>
                                <th class="py-3 px-4 border w-32">Nilai Angka</th>
                                <th class="py-3 px-4 border w-32">Nilai Huruf</th>
                                <th class="py-3 px-4 border w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($nilai as $n)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="py-2 border">{{ $loop->iteration }}</td>
                                    <td class="py-2 border">{{ is_array($n) ? $n['mata_kuliah'] : $n->mata_kuliah }}</td>
                                    <td class="py-2 border">{{ is_array($n) ? $n['sks'] : $n->sks }}</td>
                                    <td class="py-2 border">{{ is_array($n) ? $n['nilai_angka'] : $n->nilai_angka }}</td>
                                    <td class="py-2 border">{{ is_array($n) ? $n['nilai_huruf'] : $n->nilai_huruf }}</td>
                                    <td class="py-2 border flex justify-center gap-2">
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/' . (is_array($n) ? $n['id'] : $n->id) . '/edit') }}" 
                                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm transition">Edit</a>
                                            <form action="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/' . (is_array($n) ? $n['id'] : $n->id)) }}" 
                                                  method="POST" onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-gray-500 py-4">Belum ada nilai mahasiswa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
