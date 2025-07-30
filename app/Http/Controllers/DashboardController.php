<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VotingEvent;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika pengguna adalah admin, ambil data kegiatan dan kirim ke view.
        if ($user->peran === 'admin') {
            // Ambil semua data kegiatan, urutkan dari yang terbaru, dan gunakan paginasi.
            $events = VotingEvent::latest()->paginate(10);

            // Kirim variabel $events ke view 'admin.dashboard'
            return view('admin.dashboard', compact('events'));
        }

        // --- Logika untuk pemilih tetap sama ---
        if ($user->peran === 'pemilih') {
            // Cek apakah pemilih sudah memberikan suaranya.
            if ($user->sudah_memilih) {
                return view('voters.dashboard', ['status' => 'already_voted']);
            }

            // Ambil event yang terikat pada pemilih ini.
            $event = $user->votingEvent;

            // Jika pemilih tidak terikat pada event manapun.
            if (!$event) {
                return view('voters.dashboard', ['status' => 'no_event_assigned']);
            }

            // Jika event belum dimulai.
            if ($event->status === 'akan datang' || $event->waktu_mulai > now()) {
                return view('voters.dashboard', ['status' => 'event_upcoming', 'event' => $event]);
            }

            // Jika event sudah selesai.
            if ($event->status === 'selesai' || $event->waktu_selesai < now()) {
                return view('voters.dashboard', ['status' => 'event_finished', 'event' => $event]);
            }

            // Jika event sedang berlangsung dan pemilih belum memilih.
            $candidates = $event->candidates()->orderBy('nomor_urut')->get();
            return view('voters.dashboard', [
                'status' => 'can_vote',
                'event' => $event,
                'candidates' => $candidates,
            ]);
        }

        return redirect('/login');
    }
}
