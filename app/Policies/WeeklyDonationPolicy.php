<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyDonation;

class WeeklyDonationPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view finances') || $user->can('manage finances');
    }

    public function view(User $user, WeeklyDonation $weeklyDonation): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage finances');
    }

    public function update(User $user, WeeklyDonation $weeklyDonation): bool
    {
        return $user->can('manage finances');
    }

    public function delete(User $user, WeeklyDonation $weeklyDonation): bool
    {
        return $user->can('manage finances');
    }
}
