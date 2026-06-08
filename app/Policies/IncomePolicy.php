<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;

class IncomePolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view finances') || $user->can('manage finances');
    }

    public function view(User $user, Income $income): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage finances');
    }

    public function update(User $user, Income $income): bool
    {
        return $user->can('manage finances');
    }

    public function delete(User $user, Income $income): bool
    {
        return $user->can('manage finances');
    }
}
