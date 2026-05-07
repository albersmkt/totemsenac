<?php

namespace App\Support;

use App\Models\Unidade;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UnitContext
{
    public const SESSION_KEY = 'admin_selected_unidade_id';
    public const TOTEM_SESSION_KEY = 'totem_selected_unidade_id';

    private static ?int $cachedDefaultUnitId = null;

    public static function defaultUnitId(): ?int
    {
        if (self::$cachedDefaultUnitId !== null) {
            return self::$cachedDefaultUnitId;
        }

        $unitId = Unidade::query()
            ->where('nome', 'Senac Registro')
            ->value('id');

        if ($unitId === null) {
            $unitId = Unidade::query()->value('id');
        }

        self::$cachedDefaultUnitId = $unitId !== null ? (int) $unitId : null;

        return self::$cachedDefaultUnitId;
    }

    public static function resolveAdminUnitId(User $user, Request $request, bool $allowAllForSuper = true): ?int
    {
        if (! $user->hasRole('super_admin')) {
            return $user->unidade_id ?: self::defaultUnitId();
        }

        $raw = $request->session()->get(self::SESSION_KEY, 'all');

        if ($allowAllForSuper && ($raw === 'all' || $raw === null || $raw === '')) {
            return null;
        }

        if (is_numeric($raw) && Unidade::query()->whereKey((int) $raw)->exists()) {
            return (int) $raw;
        }

        return $user->unidade_id ?: self::defaultUnitId();
    }

    public static function resolveCreationUnitId(User $user, Request $request): ?int
    {
        if (! $user->hasRole('super_admin')) {
            return $user->unidade_id ?: self::defaultUnitId();
        }

        return self::resolveAdminUnitId($user, $request, false);
    }

    public static function applyAdminScope(Builder $query, User $user, Request $request, string $column = 'unidade_id'): Builder
    {
        $unitId = self::resolveAdminUnitId($user, $request, true);

        if ($user->hasRole('super_admin')) {
            if ($unitId === null) {
                return $query;
            }

            return $query->where($column, $unitId);
        }

        return $query->where($column, $unitId);
    }

    public static function resolveTotemUnitId(Request $request): ?int
    {
        $user = $request->user();
        if ($user instanceof User) {
            if ($user->hasRole('super_admin')) {
                return self::resolveAdminUnitId($user, $request, true) ?: self::defaultUnitId();
            }

            return $user->unidade_id ?: self::defaultUnitId();
        }

        $queryUnit = $request->query('unidade');
        if (is_numeric($queryUnit) && Unidade::query()->whereKey((int) $queryUnit)->exists()) {
            $unitId = (int) $queryUnit;
            if ($request->hasSession()) {
                $request->session()->put(self::TOTEM_SESSION_KEY, $unitId);
            }

            return $unitId;
        }

        if ($request->hasSession()) {
            $sessionUnit = $request->session()->get(self::TOTEM_SESSION_KEY);
            if (is_numeric($sessionUnit) && Unidade::query()->whereKey((int) $sessionUnit)->exists()) {
                return (int) $sessionUnit;
            }
        }

        return self::defaultUnitId();
    }
}
