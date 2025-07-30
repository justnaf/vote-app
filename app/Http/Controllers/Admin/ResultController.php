<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VotingEvent;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Menampilkan halaman hasil voting.
     */
    public function index(Request $request)
    {
        // Ambil semua event yang statusnya tidak 'akan datang' untuk dropdown
        $events = VotingEvent::where('status', '!=', 'akan datang')
            ->orderBy('nama_kegiatan')
            ->get();

        $selectedEvent = null;
        $results = [];
        $totalVotesInEvent = 0;

        // Cek jika ada event_id yang dipilih dari form (via query string)
        if ($request->has('event_id') && $request->input('event_id') != '') {
            $selectedEvent = VotingEvent::with('candidates')->find($request->input('event_id'));

            if ($selectedEvent) {
                // Hitung total suara untuk event ini
                $totalVotesInEvent = $selectedEvent->votes()->count();

                // Siapkan data hasil untuk setiap kandidat
                $results = $selectedEvent->candidates->map(function ($candidate) use ($totalVotesInEvent) {
                    $voteCount = $candidate->votes()->count();
                    // Hitung persentase, hindari pembagian dengan nol
                    $percentage = ($totalVotesInEvent > 0) ? ($voteCount / $totalVotesInEvent) * 100 : 0;

                    return (object)[
                        'nama_kandidat' => $candidate->nama_kandidat,
                        'foto_kandidat' => $candidate->foto_kandidat,
                        'vote_count' => $voteCount,
                        'percentage' => round($percentage, 2),
                    ];
                })->sortByDesc('vote_count'); // Urutkan dari suara terbanyak
            }
        }

        return view('admin.result', compact('events', 'selectedEvent', 'results', 'totalVotesInEvent'));
    }
}
