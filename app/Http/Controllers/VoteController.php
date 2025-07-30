<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Menyimpan suara yang diberikan oleh pemilih.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $event = $user->votingEvent;

        // Validasi ganda untuk memastikan pemilih memenuhi syarat
        if (!$event || $user->sudah_memilih || $event->status !== 'berlangsung') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak diizinkan untuk memilih saat ini.');
        }

        $request->validate([
            'kandidat' => 'required',
        ]);

        $selectedCandidates = (array) $request->input('kandidat');

        // Validasi jumlah pilihan
        if (count($selectedCandidates) > $event->maks_pilihan) {
            return back()->with('error', 'Anda memilih lebih banyak kandidat dari yang diizinkan.');
        }

        DB::transaction(function () use ($user, $event, $selectedCandidates) {
            // 1. Catat setiap suara
            foreach ($selectedCandidates as $candidateId) {
                Vote::create([
                    'id_kegiatan' => $event->id,
                    'id_pemilih' => $user->id,
                    'id_kandidat' => $candidateId,
                ]);
            }

            // 2. Tandai bahwa pemilih sudah selesai memilih
            $user->update(['sudah_memilih' => true]);
        });

        return redirect()->route('dashboard')->with('success', 'Terima kasih, suara Anda telah berhasil direkam.');
    }
}
