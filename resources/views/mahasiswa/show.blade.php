<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Data Mahasiswa --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Informasi Mahasiswa</h3>
                <table class="min-w-full text-left border border-gray-200 dark:border-gray-700">
                    <tbody class="text-gray-700 dark:text-gray-300">
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-50 dark:bg-gray-700">NIM</th>
                            <td class="px-4 py-2">{{ $mhs->nim }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-50 dark:bg-gray-700">Nama</th>
                            <td class="px-4 py-2">{{ $mhs->nama }}</td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-4 py-2 bg-gray-50 dark:bg-gray-700">Fakultas</th>
                            <td class="px-4 py-2">{{ $mhs->prodi->fakultas->nama_fakultas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-2 bg-gray-50 dark:bg-gray-700">Program Studi</th>
                            <td class="px-4 py-2">{{ $mhs->prodi->nama_prodi ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Nilai Mahasiswa --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Daftar Nilai</h3>
                    <a href="{{ url('/mahasiswa/' . $mhs->id . '/nilai/create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                       + Tambah Nilai
                    </a>
                </div>

                <table class="min-w-full border text-center">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="py-3 border">No</th>
                            <th class="py-3 border">Mata Kuliah</th>
                            <th class="py-3 border">SKS</th>
                            <th class="py-3 border">Nilai Angka</th>
                            <th class="py-3 border">Nilai Huruf</th>
                            <th class="py-3 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mhs->nilai as $n)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-2 border">{{ $loop->iteration }}</td>
                                <td class="py-2 border">{{ $n->mata_kuliah }}</td>
                                <td class="py-2 border">{{ $n->sks }}</td>
                                <td class="py-2 border">{{ $n->nilai_angka }}</td>
                                <td class="py-2 border">{{ $n->nilai_huruf }}</td>
                                <td class="py-2 border flex justify-center gap-2">
                                    <a href="{{ url('/mahasiswa/' . $mhs->id . '/nilai/' . $n->id . '/edit') }}" 
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                       Edit
                                    </a>
                                    <form action="{{ url('/mahasiswa/' . $mhs->id . '/nilai/' . $n->id) }}" 
                                          method="POST" onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-gray-500 dark:text-gray-400">Belum ada data nilai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tombol Kembali --}}
            <div class="flex justify-end">
                <a href="{{ route('mahasiswa.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                   ← Kembali ke Daftar Mahasiswa
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
