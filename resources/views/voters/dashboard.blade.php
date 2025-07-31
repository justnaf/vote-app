@extends('layouts.voters')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg max-w-5xl mx-auto">
    {{-- Notifikasi Sukses atau Gagal --}}
    @include('includes.alert')

    {{-- Konten dinamis berdasarkan status dari controller --}}
    @switch($status)
    {{-- Kasus 1: Pemilih bisa memberikan suara --}}
    @case('can_vote')
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900">{{ $event->nama_kegiatan }}</h1>
        <p class="mt-2 text-gray-600 max-w-2xl mx-auto">{{ $event->deskripsi }}</p>
        @if($event->tipe_vote == 'formatur')
        {{-- Teks diubah agar sesuai dengan validasi yang ketat --}}
        <p class="mt-2 text-sm font-semibold text-indigo-600 bg-indigo-100 inline-block px-3 py-1 rounded-full">Pilih tepat {{ $event->maks_pilihan }} kandidat</p>
        @endif
    </div>

    {{-- Menampilkan error validasi di sini --}}
    @error('kandidat')
    <div class="mt-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
        <p class="font-bold">Perhatian!</p>
        <p>{{ $message }}</p>
    </div>
    @enderror

    <form action="{{ route('vote.store') }}" method="POST" class="mt-10">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($candidates as $candidate)
            <label class="relative flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer transition-all hover:border-indigo-500 hover:shadow-md has-[:checked]:border-indigo-600 has-[:checked]:ring-2 has-[:checked]:ring-indigo-300">
                @if($event->tipe_vote == 'langsung')
                <input type="radio" name="kandidat" value="{{ $candidate->id }}" class="absolute top-4 right-4 h-5 w-5 text-indigo-600 focus:ring-indigo-500" required>
                @else
                <input type="checkbox" name="kandidat[]" value="{{ $candidate->id }}" class="absolute top-4 right-4 h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                @endif
                <img src="{{ $candidate->foto_kandidat ? asset('storage/' . $candidate->foto_kandidat) : 'https://placehold.co/150x150/e2e8f0/718096?text=Foto' }}" alt="Foto {{ $candidate->nama_kandidat }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-sm">
                <span class="mt-4 font-bold text-lg text-gray-800 text-center">{{ $candidate->nomor_urut }}. {{ $candidate->nama_kandidat }}</span>
                <p class="mt-1 text-sm text-gray-500 text-center">{{ $candidate->asal }}</p>
            </label>
            @endforeach
        </div>
        <div class="mt-10 text-center">
            <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white font-bold py-3 px-10 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform hover:scale-105">
                Kirim Suara
            </button>
        </div>
    </form>
    @break

    {{-- Kasus 2: Pemilih sudah memilih --}}
    @case('already_voted')
    <div class="text-center py-12">
        <h1 class="text-2xl font-bold text-gray-800">Terima Kasih!</h1>
        <p class="mt-2 text-gray-600">Anda telah berpartisipasi dalam kegiatan e-voting ini. Suara Anda sudah kami rekam.</p>
    </div>
    @break

    {{-- Kasus 3 & 4: Event belum mulai atau sudah selesai --}}
    @case('event_upcoming')
    @case('event_finished')
    <div class="text-center py-12">
        <h1 class="text-2xl font-bold text-gray-800">
            Kegiatan {{ $status == 'event_upcoming' ? 'Akan Datang' : 'Telah Selesai' }}
        </h1>
        <p class="mt-2 text-gray-600">
            Kegiatan "{{ $event->nama_kegiatan }}" {{ $status == 'event_upcoming' ? 'akan dimulai pada' : 'telah berakhir pada' }}
            <span class="font-semibold">{{ \Carbon\Carbon::parse($status == 'event_upcoming' ? $event->waktu_mulai : $event->waktu_selesai)->format('d F Y, H:i') }}</span>.
        </p>
    </div>
    @break

    {{-- Kasus Default: Tidak terikat event atau status lain --}}
    @default
    <div class="text-center py-12">
        <h1 class="text-2xl font-bold text-gray-800">Informasi</h1>
        <p class="mt-2 text-gray-600">Akun Anda belum terdaftar pada kegiatan e-voting manapun. Silakan hubungi admin.</p>
    </div>
    @endswitch
</div>
@endsection
