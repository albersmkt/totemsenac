<?php

namespace App\Policies;

use App\Models\Unidade;
use App\Models\User;

class UnidadePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin_unidade']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Unidade $unidade): bool
    {
        return $user->hasRole('super_admin') || ($user->hasRole('admin_unidade') && $user->unidade_id === $unidade->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Unidade $unidade): bool
    {
        return $user->hasRole('super_admin') || ($user->hasRole('admin_unidade') && $user->unidade_id === $unidade->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Unidade $unidade): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Unidade $unidade): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Unidade $unidade): bool
    {
        return $user->hasRole('super_admin');
    }
}