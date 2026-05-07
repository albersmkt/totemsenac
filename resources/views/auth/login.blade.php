<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="'Senha'" />
            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-senac-orange shadow-sm focus:ring-senac-orange" name="remember">
                <span class="ms-2 text-sm text-slate-600">Lembrar-me</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4 gap-3">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-slate-600 hover:text-senac-blue rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-senac-orange" href="{{ route('password.request') }}">
                    Esqueci minha senha
                </a>
            @endif

            <x-primary-button>
                Entrar
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>
