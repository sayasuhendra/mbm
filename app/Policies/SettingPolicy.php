<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('manage settings');
    }

    public function view(User $user, Setting $setting): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage settings');
    }

    public function update(User $user, Setting $setting): bool
    {
        return $user->can('manage settings');
    }

    public function delete(User $user, Setting $setting): bool
    {
        return $user->can('manage settings');
    }
}
