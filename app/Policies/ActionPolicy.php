<?php

namespace App\Policies;

use App\Models\Action;
use App\Models\User;

class ActionPolicy
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
        return $user->hasAnyRole(['operador', 'admin_unidade']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Action $action): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $action->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $action->created_by === $user->id
            && (int) $action->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['operador', 'admin_unidade']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Action $action): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $action->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $action->created_by === $user->id
            && (int) $action->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Action $action): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $action->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $action->created_by === $user->id
            && (int) $action->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Action $action): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $action->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $action->created_by === $user->id
            && (int) $action->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Action $action): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $action->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $action->created_by === $user->id
            && (int) $action->unidade_id === (int) $user->unidade_id;
    }
}
