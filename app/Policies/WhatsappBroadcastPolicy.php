<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WhatsappBroadcast;

class WhatsappBroadcastPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view broadcasts') || $user->can('manage broadcasts');
    }

    public function view(User $user, WhatsappBroadcast $whatsappBroadcast): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage broadcasts');
    }

    public function update(User $user, WhatsappBroadcast $whatsappBroadcast): bool
    {
        return $user->can('manage broadcasts');
    }

    public function delete(User $user, WhatsappBroadcast $whatsappBroadcast): bool
    {
        return $user->can('manage broadcasts');
    }
}
