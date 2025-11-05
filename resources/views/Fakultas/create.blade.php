<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Fakultas') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('fakultas.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nama_fakultas" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Nama Fakultas</label>
                        <input type="text" name="nama_fakultas" id="nama_fakultas"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white"
                               value="{{ old('nama_fakultas') }}" pattern="[A-Za-z\s]+" required>
                        @error('nama_fakultas')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('fakultas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Kembali
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
