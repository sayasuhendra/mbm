<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('Super Admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view finances') || $user->can('manage finances');
    }

    public function view(User $user, Expense $expense): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can('manage finances');
    }

    public function update(User $user, Expense $expense): bool
    {
        return $user->can('manage finances');
    }

    public function delete(User $user, Expense $expense): bool
    {
        return $user->can('manage finances');
    }
}
