<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'peran',
        'id_kegiatan', // <-- Baru: Untuk mengikat pemilih ke event
        'sudah_memilih',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'sudah_memilih' => 'boolean',
        ];
    }

    /**
     * Relasi ke kegiatan yang dibuat oleh admin ini.
     */
    public function createdVotingEvents(): HasMany
    {
        return $this->hasMany(VotingEvent::class, 'id_admin_pembuat');
    }

    /**
     * Relasi ke kegiatan vote tempat pemilih ini terdaftar.
     * Akan bernilai null untuk admin.
     */
    public function votingEvent(): BelongsTo
    {
        return $this->belongsTo(VotingEvent::class, 'id_kegiatan');
    }

    /**
     * Relasi ke semua suara yang diberikan oleh user ini.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'id_pemilih');
    }
}
