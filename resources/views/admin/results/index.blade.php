@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Halaman -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Hasil Voting</h1>
        <p class="mt-1 text-gray-600">Pilih kegiatan untuk melihat hasil perolehan suara secara langsung.</p>
    </div>

    <!-- Form Pemilihan Kegiatan -->
    <div class="p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.results.index') }}" method="GET">
            <label for="event_id" class="block text-sm font-medium text-gray-700">Pilih Kegiatan</label>
            <div class="flex items-center mt-1 space-x-2">
                <select name="event_id" id="event_id" required class="block p-2 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled {{ !request('event_id') ? 'selected' : '' }}>-- Pilih salah satu --</option>
                    @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->nama_kegiatan }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Kontainer Hasil -->
    @if ($selectedEvent)
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="pb-4 mb-4 border-b flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $selectedEvent->nama_kegiatan }}</h2>
                <p class="text-sm text-gray-600">Total Suara Masuk: <span class="font-semibold">{{ $totalVotesInEvent }}</span></p>
            </div>
            {{-- Tombol Ekspor PDF --}}
            <a href="{{ route('admin.results.export.pdf', $selectedEvent) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 border border-transparent rounded-md hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Export ke PDF
            </a>
        </div>

        <div class="space-y-6">
            @forelse ($results as $result)
            <div class="flex items-center space-x-4">
                <!-- Foto & Nama -->
                <div class="flex-shrink-0 w-32 flex flex-col items-center">
                    <img class="w-16 h-16 rounded-full object-cover" src="{{ $result->foto_kandidat ? asset('storage/' . $result->foto_kandidat) : 'https://ui-avatars.com/api/?name=' . urlencode($result->nama_kandidat) . '&color=7F9CF5&background=EBF4FF' }}" alt="Foto {{ $result->nama_kandidat }}">
                    <span class="mt-2 text-sm font-medium text-gray-800 text-center">{{ $result->nama_kandidat }}</span>
                </div>

                <!-- Bar & Jumlah Suara -->
                <div class="flex-grow">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-indigo-700">{{ $result->vote_count }} Suara</span>
                        <span class="text-sm font-medium text-gray-500">{{ $result->percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-indigo-600 h-4 rounded-full" style="width: {{ $result->percentage }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500">Belum ada suara yang masuk untuk kegiatan ini.</p>
            @endforelse
        </div>
    </div>
    @endif
</div>
@endsection
