@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Buat Kegiatan Baru</h1>
        <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
            &larr; Kembali ke Daftar Kegiatan
        </a>
    </div>

    <div class="p-8 bg-white rounded-lg shadow-md">
        <form x-data="{ tipe: '{{ old('tipe_vote', 'langsung') }}' }" action="{{ route('admin.events.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required class="block w-full mt-1 border-gray-300 p-2 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('nama_kegiatan') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 p-2 focus:border-indigo-500">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                    <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('waktu_mulai') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                    <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('waktu_selesai') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="tipe_vote" class="block text-sm font-medium text-gray-700">Tipe Vote</label>
                <select name="tipe_vote" id="tipe_vote" required x-model="tipe" class="block w-full mt-1 border-gray-300 p-2 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="langsung">Langsung (1 Pilihan)</option>
                    <option value="formatur">Formatur (Banyak Pilihan)</option>
                </select>
                @error('tipe_vote') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div x-show="tipe === 'formatur'" x-transition>
                <label for="maks_pilihan" class="block text-sm font-medium text-gray-700">Maksimal Pilihan untuk Formatur</label>
                <input type="number" name="maks_pilihan" id="maks_pilihan" value="{{ old('maks_pilihan', 1) }}" min="1" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Isi kolom ini hanya jika tipe vote adalah 'Formatur'.</p>
                @error('maks_pilihan') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
