<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\VotingEvent;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Menampilkan halaman manajemen kandidat untuk sebuah event.
     */
    public function index(VotingEvent $event)
    {
        // Ambil semua kandidat yang berelasi dengan event ini
        $candidates = $event->candidates()->orderBy('nomor_urut')->get();

        return view('admin.candidates.index', compact('event', 'candidates'));
    }

    /**
     * Menyimpan kandidat baru ke database.
     */
    public function store(Request $request, VotingEvent $event)
    {
        $validated = $request->validate([
            'nama_kandidat' => 'required|string|max:255',
            'nomor_urut' => 'required|integer|min:1|unique:candidates,nomor_urut,NULL,id,id_kegiatan,' . $event->id,
            'visi_misi' => 'nullable|string',
            'foto_kandidat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'asal' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto_kandidat')) {
            // Simpan file gambar dan dapatkan path-nya
            $validated['foto_kandidat'] = $request->file('foto_kandidat')->store('candidate-photos', 'public');
        }

        // Tambahkan id_kegiatan secara otomatis
        $validated['id_kegiatan'] = $event->id;

        Candidate::create($validated);

        return back()->with('success', 'Kandidat baru berhasil ditambahkan.');
    }

    /**
     * Menghapus kandidat dari database.
     */
    public function destroy(VotingEvent $event, Candidate $candidate)
    {
        // Pastikan kandidat yang akan dihapus benar-benar milik event tersebut (keamanan tambahan)
        if ($candidate->id_kegiatan !== $event->id) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        // Hapus file foto jika ada
        if ($candidate->foto_kandidat) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($candidate->foto_kandidat);
        }

        $candidate->delete();

        return back()->with('success', 'Kandidat berhasil dihapus.');
    }
}
