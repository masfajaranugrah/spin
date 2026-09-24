<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $fillable = [
        'participant_id',
        'prize_id',
        'participant_name',
        'participant_address',
        'participant_phone',
        'giveaway_name',
        'prize_name',
        'drawn_at',
    ];

    protected function casts(): array
    {
        return [
            'drawn_at' => 'datetime',
        ];
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function prize(): BelongsTo
    {
        return $this->belongsTo(Prize::class);
    }

    public function getWinnerNameAttribute(): string
    {
        return $this->participant_name ?? $this->participant?->name ?? 'Peserta Terhapus';
    }

    public function getWinnerAddressAttribute(): ?string
    {
        return $this->participant_address ?? $this->participant?->address;
    }

    public function getWinnerPhoneAttribute(): ?string
    {
        return $this->participant_phone ?? $this->participant?->phone_number;
    }
}
