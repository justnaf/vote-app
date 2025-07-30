@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Dashboard -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kegiatan Voting</h1>
        <p class="mt-1 text-gray-600">Kelola semua kegiatan e-voting dari sini.</p>
    </div>

    @include('includes.alert')

    <!-- Tombol Aksi Utama -->
    <div class="flex justify-end">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Buat Kegiatan Baru
        </a>
    </div>

    <!-- Tabel Daftar Kegiatan -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Kegiatan</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Waktu Mulai</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Waktu Selesai</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($events as $event)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $event->nama_kegiatan }}</div>
                        <div class="text-sm text-gray-500">{{ ucfirst($event->tipe_vote) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($event->status == 'selesai')
                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full">Selesai</span>
                        @else
                        <form action="{{ route('admin.events.status.update', $event) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            @if ($event->status == 'akan datang')
                            <input type="hidden" name="status" value="berlangsung">
                            <button type="submit" class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full hover:bg-yellow-200 transition-colors" title="Klik untuk memulai">
                                Akan Datang
                            </button>
                            @elseif ($event->status == 'berlangsung')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full hover:bg-green-200 transition-colors" title="Klik untuk menyelesaikan">
                                Berlangsung
                            </button>
                            @endif
                        </form>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $event->waktu_mulai ? \Carbon\Carbon::parse($event->waktu_mulai)->format('d M Y, H:i') : '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $event->waktu_selesai ? \Carbon\Carbon::parse($event->waktu_selesai)->format('d M Y, H:i') : '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                        <a href="{{ route('admin.events.candidates.index', $event) }}" class="text-orange-600 hover:text-indigo-900">Kandidat</a>
                        |
                        <a href="{{ route('admin.events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        |
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Semua data terkait (kandidat, suara) akan ikut terhapus.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500">
                        Belum ada kegiatan yang dibuat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection
