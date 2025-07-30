<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = [
        'id_kegiatan',
        'id_pemilih',
        'id_kandidat',
    ];

    const UPDATED_AT = null;

    public function votingEvent(): BelongsTo
    {
        return $this->belongsTo(VotingEvent::class, 'id_kegiatan');
    }

    public function voter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pemilih');
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'id_kandidat');
    }
}
