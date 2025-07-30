@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Halaman -->
    <div>
        <a href="{{ route('admin.events.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors mb-2 inline-block">
            &larr; Kembali ke Daftar Kegiatan
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Kandidat: {{ $event->nama_kegiatan }}</h1>
        <p class="mt-1 text-gray-600">Tambah, lihat, dan hapus kandidat untuk kegiatan ini.</p>
    </div>

    <!-- Notifikasi Sesi -->
    @include('includes.alert')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Kandidat Baru</h3>
                <form action="{{ route('admin.events.candidates.store', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nama_kandidat" class="block text-sm font-medium text-gray-700">Nama Kandidat</label>
                        <input type="text" name="nama_kandidat" id="nama_kandidat" value="{{ old('nama_kandidat') }}" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nama_kandidat') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="nomor_urut" class="block text-sm font-medium text-gray-700">Nomor Urut</label>
                        <input type="number" name="nomor_urut" id="nomor_urut" value="{{ old('nomor_urut') }}" required min="1" class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nomor_urut') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>
                    {{-- Input baru untuk 'asal' --}}
                    <div>
                        <label for="asal" class="block text-sm font-medium text-gray-700">Asal (Contoh: Kelas, Departemen)</label>
                        <input type="text" name="asal" id="asal" value="{{ old('asal') }}" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('asal') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="visi_misi" class="block text-sm font-medium text-gray-700">Visi & Misi (Singkat)</label>
                        <textarea name="visi_misi" id="visi_misi" rows="3" class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('visi_misi') }}</textarea>
                    </div>
                    <div>
                        <label for="foto_kandidat" class="block text-sm font-medium text-gray-700">Foto Kandidat</label>
                        <input type="file" name="foto_kandidat" id="foto_kandidat" class="block p-2 w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('foto_kandidat') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Kandidat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Daftar Kandidat -->
        <div class="lg:col-span-2">
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No.</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Kandidat</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($candidates as $candidate)
                        <tr>
                            <td class="px-6 py-4 text-sm font-bold text-gray-500 whitespace-nowrap">{{ $candidate->nomor_urut }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img class="w-10 h-10 rounded-full object-cover" src="{{ $candidate->foto_kandidat ? asset('storage/' . $candidate->foto_kandidat) : 'https://ui-avatars.com/api/?name=' . urlencode($candidate->nama_kandidat) . '&color=7F9CF5&background=EBF4FF' }}" alt="Foto {{ $candidate->nama_kandidat }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $candidate->nama_kandidat }}</div>
                                        {{-- Menampilkan 'asal' kandidat --}}
                                        <div class="text-sm text-gray-500">{{ $candidate->asal }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <form action="{{ route('admin.events.candidates.destroy', [$event, $candidate]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-sm text-center text-gray-500">Belum ada kandidat yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
