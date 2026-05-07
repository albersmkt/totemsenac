<x-guest-layout>
    <div class="mb-4 text-sm text-slate-600">
        Informe seu email para receber o link de redefinição de senha.
    </div>

    @if (config('mail.default') === 'log')
        <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-700">
            Ambiente local: o link e registrado no arquivo <code>storage/logs/laravel.log</code>.
        </div>
    @endif

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-between gap-3">
            <a href="{{ route('login') }}" class="text-sm underline text-slate-600 hover:text-senac-blue">Voltar para login</a>
            <x-primary-button>
                Enviar link de redefinição
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
