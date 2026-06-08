<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyDonation extends Model
{
    public const STATUS_UNPAID = 'unpaid';

    public const STATUS_PAID = 'paid';

    protected $fillable = [
        'archery_participant_id',
        'week_start_date',
        'amount',
        'status',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'week_start_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(ArcheryParticipant::class, 'archery_participant_id');
    }
}
