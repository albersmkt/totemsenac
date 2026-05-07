<?php

namespace App\Policies;

use App\Models\Entrepreneur;
use App\Models\User;

class EntrepreneurPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['estudante', 'admin_unidade']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Entrepreneur $entrepreneur): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('estudante')
            && $entrepreneur->created_by === $user->id
            && (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['estudante', 'admin_unidade']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Entrepreneur $entrepreneur): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('estudante')
            && $entrepreneur->created_by === $user->id
            && (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Entrepreneur $entrepreneur): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('estudante')
            && $entrepreneur->created_by === $user->id
            && (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Entrepreneur $entrepreneur): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('estudante')
            && $entrepreneur->created_by === $user->id
            && (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Entrepreneur $entrepreneur): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('estudante')
            && $entrepreneur->created_by === $user->id
            && (int) $entrepreneur->unidade_id === (int) $user->unidade_id;
    }

    public function approve(User $user, Entrepreneur $entrepreneur): bool
    {
        return false;
    }
}
