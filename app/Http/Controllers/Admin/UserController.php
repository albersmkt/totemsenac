<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\User;
use App\Support\UnitContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const ALL_ROLES = [
        'super_admin' => 'Super Admin',
        'admin_unidade' => 'Admin da Unidade',
        'operador' => 'Operador',
        'estudante' => 'Estudante',
    ];

    public function index(Request $request)
    {
        $this->assertCanManageUsers($request->user());
        $roles = $this->availableRolesFor($request->user());

        $selectedRole = $request->query('role', 'todos');

        $query = User::query()->with(['roles', 'unidade']);
        UnitContext::applyAdminScope($query, $request->user(), $request);
        if ($request->user()->hasRole('admin_unidade') && ! $request->user()->hasRole('super_admin')) {
            $query->whereDoesntHave('roles', fn ($roleQuery) => $roleQuery->where('name', 'super_admin'));
        }
        if ($selectedRole !== 'todos' && array_key_exists($selectedRole, $roles)) {
            $query->role($selectedRole);
        }

        $users = $query->orderBy('name')->paginate(12)->withQueryString();

        $roleKeys = array_keys($roles);
        $countQuery = function () use ($request) {
            $query = UnitContext::applyAdminScope(User::query(), $request->user(), $request);
            if ($request->user()->hasRole('admin_unidade') && ! $request->user()->hasRole('super_admin')) {
                $query->whereDoesntHave('roles', fn ($roleQuery) => $roleQuery->where('name', 'super_admin'));
            }

            return $query;
        };
        $counts = [
            'todos' => $countQuery()->count(),
        ];
        foreach ($roleKeys as $roleKey) {
            $counts[$roleKey] = $countQuery()->role($roleKey)->count();
        }

        return view('admin.users.index', compact('users', 'roles', 'selectedRole', 'counts'));
    }

    public function create()
    {
        $authUser = auth()->user();
        $this->assertCanManageUsers($authUser);
        $roles = $this->availableRolesFor($authUser);
        $unidades = $this->availableUnitsFor($authUser);

        return view('admin.users.create', compact('roles', 'unidades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $authUser = $request->user();
        $this->assertCanManageUsers($authUser);
        $allowedRoles = array_keys($this->availableRolesFor($authUser));
        $allowedUnitIds = $this->availableUnitsFor($authUser)->pluck('id')->all();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in($allowedRoles)],
            'unidade_id' => ['required', Rule::in($allowedUnitIds)],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'unidade_id' => (int) $data['unidade_id'],
        ]);

        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Usuario criado com sucesso.');
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();
        $this->assertCanManageUsers($authUser, $user);
        $roles = $this->availableRolesFor($authUser);
        $unidades = $this->availableUnitsFor($authUser);

        $currentRole = $user->roles->first()?->name;

        return view('admin.users.edit', compact('user', 'roles', 'currentRole', 'unidades'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $authUser = $request->user();
        $this->assertCanManageUsers($authUser, $user);
        $allowedRoles = array_keys($this->availableRolesFor($authUser));
        $allowedUnitIds = $this->availableUnitsFor($authUser)->pluck('id')->all();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in($allowedRoles)],
            'unidade_id' => ['required', Rule::in($allowedUnitIds)],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->unidade_id = (int) $data['unidade_id'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Usuario atualizado com sucesso.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->assertCanManageUsers(request()->user(), $user);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'Voce nao pode excluir sua propria conta.']);
        }

        if ($user->hasRole('super_admin')) {
            $superAdmins = User::role('super_admin')->count();
            if ($superAdmins <= 1) {
                return back()->withErrors(['user' => 'Nao e possivel excluir o ultimo super admin.']);
            }
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Usuario removido com sucesso.');
    }

    private function availableRolesFor(User $authUser): array
    {
        if ($authUser->hasRole('super_admin')) {
            return self::ALL_ROLES;
        }

        return [
            'admin_unidade' => self::ALL_ROLES['admin_unidade'],
            'operador' => self::ALL_ROLES['operador'],
            'estudante' => self::ALL_ROLES['estudante'],
        ];
    }

    private function availableUnitsFor(User $authUser)
    {
        if ($authUser->hasRole('super_admin')) {
            return Unidade::query()->orderBy('nome')->get();
        }

        return Unidade::query()
            ->whereKey($authUser->unidade_id)
            ->orderBy('nome')
            ->get();
    }

    private function assertCanManageUsers(User $authUser, ?User $target = null): void
    {
        if (! $authUser->hasAnyRole(['super_admin', 'admin_unidade'])) {
            abort(403);
        }

        if ($target === null || $authUser->hasRole('super_admin')) {
            return;
        }

        if ((int) $target->unidade_id !== (int) $authUser->unidade_id) {
            abort(403);
        }

        if ($target->hasRole('super_admin')) {
            abort(403);
        }
    }
}
