<?php

namespace App\Http\Controllers\Admin;

use App\Exports\VotersExport; // <-- Tambahkan ini
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VotingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel; // <-- Tambahkan ini

class VoterController extends Controller
{
    /**
     * Menampilkan halaman manajemen pemilih.
     */
    public function index()
    {
        $events = VotingEvent::orderBy('nama_kegiatan')->get();
        return view('admin.voters.index', compact('events'));
    }

    /**
     * Membuat sejumlah pengguna pemilih untuk event tertentu.
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'id_kegiatan' => 'required|exists:voting_events,id',
            'jumlah_pemilih' => 'required|integer|min:1|max:500',
        ]);

        $eventId = $validated['id_kegiatan'];
        $jumlah = $validated['jumlah_pemilih'];
        $generatedUsers = [];

        DB::transaction(function () use ($eventId, $jumlah, &$generatedUsers) {
            for ($i = 0; $i < $jumlah; $i++) {
                $username = 'voter-' . Str::random(6);
                $password = Str::random(8);

                $user = User::create([
                    'username' => $username,
                    'password' => Hash::make($password),
                    'peran' => 'pemilih',
                    'id_kegiatan' => $eventId,
                ]);

                $generatedUsers[] = [
                    'username' => $username,
                    'password' => $password,
                ];
            }
        });

        return redirect()->route('admin.voters.index')
            ->with('success', "$jumlah pemilih baru berhasil dibuat.")
            ->with('generated_users', $generatedUsers)
            ->with('event_id_generated', $eventId);
    }

    /**
     * Mengekspor data pemilih menggunakan Laravel Excel.
     */
    public function export(Request $request)
    {
        $request->validate([
            'generated_data' => 'required|json'
        ]);

        $usersToExport = json_decode($request->input('generated_data'), true);

        if (empty($usersToExport)) {
            return back()->with('error', 'Tidak ada data untuk diekspor.');
        }

        $fileName = 'voters-credentials-' . date('Y-m-d') . '.xlsx';

        // Gunakan kelas VotersExport untuk men-download file
        return Excel::download(new VotersExport($usersToExport), $fileName);
    }
}
