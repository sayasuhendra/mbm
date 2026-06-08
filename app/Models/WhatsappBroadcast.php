<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappBroadcast extends Model
{
    public const TARGET_ALL = 'all';

    public const TARGET_ACTIVE = 'active';

    public const TARGET_INACTIVE = 'inactive';

    public const STATUS_DRAFT = 'draft';

    public const STATUS_SCHEDULED = 'scheduled';

    public const STATUS_SENT = 'sent';

    protected $fillable = ['title', 'message', 'target', 'status', 'scheduled_at', 'sent_at', 'created_by'];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(BroadcastLog::class);
    }
}
