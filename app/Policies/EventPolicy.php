<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
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
    public function view(User $user, Event $event): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $event->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $event->created_by === $user->id
            && (int) $event->unidade_id === (int) $user->unidade_id;
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
    public function update(User $user, Event $event): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $event->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $event->created_by === $user->id
            && (int) $event->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $event->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $event->created_by === $user->id
            && (int) $event->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $event->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $event->created_by === $user->id
            && (int) $event->unidade_id === (int) $user->unidade_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        if ($user->hasRole('admin_unidade')) {
            return (int) $event->unidade_id === (int) $user->unidade_id;
        }

        return $user->hasRole('operador')
            && $event->created_by === $user->id
            && (int) $event->unidade_id === (int) $user->unidade_id;
    }
}
