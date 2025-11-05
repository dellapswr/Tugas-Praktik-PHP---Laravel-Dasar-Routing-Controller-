<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('prodi.update', $prodi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="fakultas_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Fakultas
                        </label>
                        <select name="fakultas_id" id="fakultas_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white" required>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}" {{ $prodi->fakultas_id == $f->id ? 'selected' : '' }}>
                                    {{ $f->nama_fakultas }}
                                </option>
                            @endforeach
                        </select>
                        @error('fakultas_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nama_prodi" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Nama Prodi
                        </label>
                        <input type="text" name="nama_prodi" id="nama_prodi"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400 dark:bg-gray-700 dark:text-white"
                               value="{{ old('nama_prodi', $prodi->nama_prodi) }}" pattern="[A-Za-z\s]+" required>
                        @error('nama_prodi')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('prodi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Kembali
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
