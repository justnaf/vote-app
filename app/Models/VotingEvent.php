<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VotingEvent extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'tipe_vote',
        'maks_pilihan',
        'status',
        'id_admin_pembuat',
    ];

    /**
     * Relasi ke admin (user) yang membuat kegiatan ini.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin_pembuat');
    }

    /**
     * Relasi ke semua pemilih (voters) yang terdaftar di kegiatan ini.
     */
    public function voters(): HasMany
    {
        return $this->hasMany(User::class, 'id_kegiatan');
    }

    /**
     * Relasi ke semua kandidat dalam kegiatan ini.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'id_kegiatan');
    }

    /**
     * Relasi ke semua suara yang masuk untuk kegiatan ini.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'id_kegiatan');
    }
}
