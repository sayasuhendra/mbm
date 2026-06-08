<?php

namespace App\Policies;

use App\Models\ArcheryParticipant;
use App\Models\User;

class ArcheryParticipantPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view participants') || $user->can('manage participants');
    }

    public function view(User $user, ArcheryParticipant $archeryParticipant): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage participants');
    }

    public function update(User $user, ArcheryParticipant $archeryParticipant): bool
    {
        return $user->can('manage participants');
    }

    public function delete(User $user, ArcheryParticipant $archeryParticipant): bool
    {
        return $user->can('manage participants');
    }
}
