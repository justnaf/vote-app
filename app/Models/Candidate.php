<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{

    protected $fillable = [
        'id_kegiatan',
        'nama_kandidat',
        'nomor_urut',
        'visi_misi',
        'asal',
        'foto_kandidat',
    ];

    public function votingEvent(): BelongsTo
    {
        return $this->belongsTo(VotingEvent::class, 'id_kegiatan');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'id_kandidat');
    }
}
