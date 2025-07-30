@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Halaman -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pemilih</h1>
        <p class="mt-1 text-gray-600">Buat akun pemilih secara massal untuk kegiatan tertentu.</p>
    </div>

    <!-- Notifikasi Sesi -->
    @include('includes.alert')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Form Generate -->
        <div class="lg:col-span-1">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Akun Pemilih</h3>
                <form action="{{ route('admin.voters.generate') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="id_kegiatan" class="block text-sm font-medium text-gray-700">Pilih Kegiatan</label>
                        <select name="id_kegiatan" id="id_kegiatan" required class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>-- Pilih salah satu --</option>
                            @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jumlah_pemilih" class="block text-sm font-medium text-gray-700">Jumlah Pemilih</label>
                        <input type="number" name="jumlah_pemilih" id="jumlah_pemilih" required min="1" max="500" placeholder="Contoh: 50" class="block p-2 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Hasil Generate -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Hasil Generate Terakhir</h3>
                    @if (session('generated_users'))
                    <form action="{{ route('admin.voters.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="generated_data" value="{{ json_encode(session('generated_users')) }}">
                        <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Export ke Excel
                        </button>
                    </form>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Username</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Password</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if (session('generated_users'))
                            @foreach (session('generated_users') as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $user['username'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $user['password'] }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-sm text-center text-gray-500">
                                    Belum ada data yang digenerate. Silakan gunakan form di sebelah kiri.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
