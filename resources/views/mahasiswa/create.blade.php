<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6">
                <form action="{{ route('mahasiswa.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="nim" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">NIM</label>
                        <input type="text" id="nim" name="nim"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white"
                               value="{{ old('nim') }}" pattern="[0-9]+" minlength="8" maxlength="12" required>
                        @error('nim') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nama" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Nama</label>
                        <input type="text" id="nama" name="nama"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white"
                               value="{{ old('nama') }}" pattern="[A-Za-z\s]+" required>
                        @error('nama') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="fakultas_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Fakultas</label>
                        <select id="fakultas_id" name="fakultas_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white" required>
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                        @error('fakultas_id') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="prodi_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Program Studi</label>
                        <select id="prodi_id" name="prodi_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white" required>
                            <option value="">-- Pilih Prodi --</option>
                        </select>
                        @error('prodi_id') <p class="text-red-500 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('mahasiswa.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition">
                            Kembali
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
</x-app-layout>
