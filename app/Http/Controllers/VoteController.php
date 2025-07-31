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

        // --- VALIDASI DIPERBARUI DI SINI ---

        // Siapkan aturan validasi dasar
        $rules = [
            'kandidat' => 'required',
        ];

        // Pesan error kustom
        $messages = [
            'kandidat.required' => 'Anda harus memilih setidaknya satu kandidat.',
        ];

        // Jika tipe vote adalah formatur, terapkan aturan 'size'
        if ($event->tipe_vote === 'formatur') {
            $rules['kandidat'] = 'required|array|size:' . $event->maks_pilihan;
            $messages['kandidat.size'] = 'Anda harus memilih tepat ' . $event->maks_pilihan . ' kandidat.';
        }

        $request->validate($rules, $messages);

        // --- AKHIR DARI VALIDASI YANG DIPERBARUI ---

        $selectedCandidates = (array) $request->input('kandidat');

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
