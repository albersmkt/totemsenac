<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredOperatorController extends Controller
{
    public function create(): View
    {
        $unidades = Unidade::query()->orderBy('nome')->get();

        return view('auth.register-operator', compact('unidades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'unidade_id' => ['required', 'exists:unidades,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'unidade_id' => (int) $request->integer('unidade_id'),
        ]);

        Role::findOrCreate('operador');
        $user->assignRole('operador');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('admin.dashboard'));
    }
}
