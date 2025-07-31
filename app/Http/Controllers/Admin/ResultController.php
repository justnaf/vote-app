<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VotingEvent;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

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

        return view('admin.results.index', compact('events', 'selectedEvent', 'results', 'totalVotesInEvent'));
    }
    /**
     * Membuat dan mengunduh hasil voting dalam format PDF.
     */
    public function exportPdf(VotingEvent $event)
    {
        $totalVotesInEvent = $event->votes()->count();

        $results = $event->candidates->map(function ($candidate) use ($totalVotesInEvent) {
            $voteCount = $candidate->votes()->count();
            $percentage = ($totalVotesInEvent > 0) ? ($voteCount / $totalVotesInEvent) * 100 : 0;

            // --- Logika untuk menyematkan gambar ---
            $photoData = null;
            if ($candidate->foto_kandidat) {
                $path = public_path('storage/' . $candidate->foto_kandidat);
                // Pastikan file ada sebelum dibaca
                if (File::exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    // Konversi gambar menjadi base64
                    $photoData = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            }
            // --- Akhir logika gambar ---

            return (object)[
                'nama_kandidat' => $candidate->nama_kandidat,
                'vote_count' => $voteCount,
                'percentage' => round($percentage, 2),
                'foto_data' => $photoData, // Kirim data base64 ke view
            ];
        })->sortByDesc('vote_count');

        $pdf = Pdf::loadView('admin.results.pdf', [
            'event' => $event,
            'results' => $results,
            'totalVotesInEvent' => $totalVotesInEvent,
        ]);

        $fileName = 'hasil-vote-' . \Illuminate\Support\Str::slug($event->nama_kegiatan) . '.pdf';
        return $pdf->download($fileName);
    }
}
