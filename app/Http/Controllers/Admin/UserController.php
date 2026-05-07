<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = [
            'super_admin' => 'Super Admin',
            'operador' => 'Operador',
            'estudante' => 'Estudante',
        ];

        $selectedRole = $request->query('role', 'todos');

        $query = User::query()->with('roles');
        if ($selectedRole !== 'todos' && array_key_exists($selectedRole, $roles)) {
            $query->role($selectedRole);
        }

        $users = $query->orderBy('name')->paginate(12)->withQueryString();

        $counts = [
            'todos' => User::count(),
            'super_admin' => User::role('super_admin')->count(),
            'operador' => User::role('operador')->count(),
            'estudante' => User::role('estudante')->count(),
        ];

        return view('admin.users.index', compact('users', 'roles', 'selectedRole', 'counts'));
    }

    public function create()
    {
        $roles = [
            'super_admin' => 'Super Admin',
            'operador' => 'Operador',
            'estudante' => 'Estudante',
        ];

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $roles = ['super_admin', 'operador', 'estudante'];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in($roles)],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Usuario criado com sucesso.');
    }

    public function edit(User $user)
    {
        $roles = [
            'super_admin' => 'Super Admin',
            'operador' => 'Operador',
            'estudante' => 'Estudante',
        ];

        $currentRole = $user->roles->first()?->name;

        return view('admin.users.edit', compact('user', 'roles', 'currentRole'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $roles = ['super_admin', 'operador', 'estudante'];

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in($roles)],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
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
}
