<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VotingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingEventController extends Controller
{
    /**
     * Menampilkan daftar semua kegiatan.
     */
    public function index()
    {
        $events = VotingEvent::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan form untuk membuat kegiatan baru.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Menyimpan kegiatan baru yang dibuat dari form ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input dari form
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'tipe_vote' => 'required|in:langsung,formatur',
            'maks_pilihan' => 'required_if:tipe_vote,formatur|integer|min:1|nullable',
        ]);

        // 2. Tambahkan ID admin yang sedang login
        $validated['id_admin_pembuat'] = Auth::id();

        // 3. Atur 'maks_pilihan' menjadi 1 jika tipe vote adalah 'langsung'
        if ($validated['tipe_vote'] === 'langsung') {
            $validated['maks_pilihan'] = 1;
        }

        // 4. Buat record baru di database
        VotingEvent::create($validated);

        // 5. Redirect kembali ke halaman daftar kegiatan dengan pesan sukses
        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan baru berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     * (Akan diimplementasikan nanti)
     */
    public function show(VotingEvent $event)
    {
        // Untuk saat ini, kita arahkan ke halaman edit saja.
        return redirect()->route('admin.events.edit', $event);
    }

    /**
     * Menampilkan form untuk mengedit kegiatan.
     */
    public function edit(VotingEvent $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Memperbarui data kegiatan di database.
     */
    public function update(Request $request, VotingEvent $event)
    {
        // Validasi input, sama seperti di method store
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'tipe_vote' => 'required|in:langsung,formatur',
            'maks_pilihan' => 'required_if:tipe_vote,formatur|integer|min:1|nullable',
        ]);

        if ($validated['tipe_vote'] === 'langsung') {
            $validated['maks_pilihan'] = 1;
        }

        // Update record yang ada
        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Menghapus kegiatan dari database.
     */
    public function destroy(VotingEvent $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Kegiatan berhasil dihapus!');
    }

    /**
     * Memperbarui status sebuah kegiatan vote.
     */
    public function updateStatus(Request $request, VotingEvent $event)
    {
        $request->validate([
            'status' => 'required|in:berlangsung,selesai',
        ]);

        // Logika untuk mencegah perubahan status yang tidak valid
        if ($event->status === 'akan datang' && $request->status !== 'berlangsung') {
            return back()->with('error', 'Status hanya bisa diubah menjadi "Berlangsung".');
        }
        if ($event->status === 'berlangsung' && $request->status !== 'selesai') {
            return back()->with('error', 'Status hanya bisa diubah menjadi "Selesai".');
        }
        if ($event->status === 'selesai') {
            return back()->with('error', 'Kegiatan yang sudah selesai tidak bisa diubah statusnya.');
        }

        $event->update(['status' => $request->status]);

        return back()->with('success', 'Status kegiatan berhasil diperbarui.');
    }
}
