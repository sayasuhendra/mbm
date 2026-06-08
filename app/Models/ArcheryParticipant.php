<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class ArcheryParticipant extends Model
{
    use Notifiable;

    public const STATUS_PENDING = 'pending';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    public const STATUS_EXITED = 'exited';

    protected $fillable = [
        'member_number',
        'parent_name',
        'parent_whatsapp',
        'parent_address',
        'child_name',
        'child_age',
        'child_school_class',
        'training_permission',
        'weekly_donation_amount',
        'equipment_option',
        'equipment_contribution_amount',
        'suggestion',
        'status',
        'registered_at',
    ];

    protected function casts(): array
    {
        return [
            'training_permission' => 'boolean',
            'registered_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function active($query): void
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function weeklyDonations(): HasMany
    {
        return $this->hasMany(WeeklyDonation::class);
    }

    public function routeNotificationForMail(): ?string
    {
        return null;
    }

    public static function nextMemberNumber(?Carbon $date = null): string
    {
        $date ??= now();
        $prefix = 'KPRMBM-'.$date->format('Ym').'-';
        $next = self::query()
            ->where('member_number', 'like', $prefix.'%')
            ->count() + 1;

        return $prefix.str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }
}
