<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BroadcastLog extends Model
{
    protected $fillable = [
        'whatsapp_broadcast_id',
        'archery_participant_id',
        'recipient_name',
        'recipient_whatsapp',
        'status',
        'response',
        'sent_at',
    ];

    protected function casts(): array
    {
        return ['sent_at' => 'datetime'];
    }

    public function broadcast(): BelongsTo
    {
        return $this->belongsTo(WhatsappBroadcast::class, 'whatsapp_broadcast_id');
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(ArcheryParticipant::class, 'archery_participant_id');
    }
}
