<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            {{-- Navigasi tambahan --}}
            <div class="flex gap-3">
                <a href="{{ url('/mahasiswa') }}" 
                   class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition">
                    Mahasiswa
                </a>
                <a href="{{ url('/prodi') }}" 
                   class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition">
                    Program Studi
                </a>
                <a href="{{ url('/fakultas') }}" 
                   class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition">
                    Fakultas
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center text-lg font-semibold">
                    Anda berhasil login 🎉
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
