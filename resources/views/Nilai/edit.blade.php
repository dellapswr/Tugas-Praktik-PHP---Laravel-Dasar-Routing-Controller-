<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Nilai Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl p-6">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    {{ is_array($mhs) ? $mhs['nama'] : $mhs->nama }} 
                    ({{ is_array($mhs) ? $mhs['nim'] : $mhs->nim }})
                </h3>

                <form action="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai/' . (is_array($n) ? $n['id'] : $n->id)) }}"
                      method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Mata Kuliah</label>
                        <input type="text" name="mata_kuliah"
                               class="w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white"
                               value="{{ old('mata_kuliah', is_array($n) ? $n['mata_kuliah'] : $n->mata_kuliah) }}" pattern="[A-Za-z\s]+" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">SKS</label>
                        <input type="number" name="sks"
                               class="w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white"
                               min="1" max="6" value="{{ old('sks', is_array($n) ? $n['sks'] : $n->sks) }}" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Nilai Angka</label>
                        <input type="number" name="nilai_angka"
                               class="w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white"
                               step="0.01" min="0" max="4"
                               value="{{ old('nilai_angka', is_array($n) ? $n['nilai_angka'] : $n->nilai_angka) }}" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Nilai Huruf</label>
                        <input type="text" name="nilai_huruf" readonly
                               class="w-full border-gray-300 bg-gray-100 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm"
                               value="{{ old('nilai_huruf', is_array($n) ? $n['nilai_huruf'] : $n->nilai_huruf) }}">
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ url('/mahasiswa/' . (is_array($mhs) ? $mhs['id'] : $mhs->id) . '/nilai') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">← Kembali</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Update Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
