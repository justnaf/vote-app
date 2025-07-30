@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Kegiatan: {{ $event->nama_kegiatan }}</h1>
        <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
            &larr; Kembali ke Daftar Kegiatan
        </a>
    </div>

    <!-- Kontainer Form -->
    <div class="p-8 bg-white rounded-lg shadow-md">
        <form x-data="{ tipe: '{{ old('tipe_vote', $event->tipe_vote) }}' }" action="{{ route('admin.events.update', $event) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $event->nama_kegiatan) }}" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('nama_kegiatan') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                @error('deskripsi') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Waktu Mulai & Selesai -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                    <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai', $event->waktu_mulai) }}" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('waktu_mulai') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                    <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai', $event->waktu_selesai) }}" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('waktu_selesai') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Tipe Vote -->
            <div>
                <label for="tipe_vote" class="block text-sm font-medium text-gray-700">Tipe Vote</label>
                <select name="tipe_vote" id="tipe_vote" required x-model="tipe" class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="langsung">Langsung (1 Pilihan)</option>
                    <option value="formatur">Formatur (Banyak Pilihan)</option>
                </select>
                @error('tipe_vote') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Maks Pilihan (khusus formatur) -->
            <div x-show="tipe === 'formatur'" x-transition>
                <label for="maks_pilihan" class="block text-sm font-medium text-gray-700">Maksimal Pilihan untuk Formatur</label>
                <input type="number" name="maks_pilihan" id="maks_pilihan" value="{{ old('maks_pilihan', $event->maks_pilihan) }}" min="1" class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Isi kolom ini hanya jika tipe vote adalah 'Formatur'.</p>
                @error('maks_pilihan') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Perbarui Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
