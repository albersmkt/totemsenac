<x-guest-layout>
    <x-slot name="sideTitle">Gestão administrativa da unidade</x-slot>
    <x-slot name="sideDescription">Cadastre responsáveis pela administração, aprovações e gestão dos conteúdos da unidade.</x-slot>
    <x-slot name="pageTitle">Cadastro de admin da unidade</x-slot>
    <x-slot name="pageDescription">Area para equipe administrativa da unidade.</x-slot>

    <form method="POST" action="{{ route('register.unit-admin') }}">
        @csrf

        <div class="mb-4 text-sm text-gray-600">
            Cadastro de admin da unidade.
        </div>

        <div>
            <x-input-label for="name" :value="'Nome'" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="unidade_id" :value="'Unidade'" />
            <select id="unidade_id" name="unidade_id" required class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-senac-orange focus:ring-senac-orange">
                <option value="">Selecione</option>
                @foreach (($unidades ?? collect()) as $unidade)
                    <option value="{{ $unidade->id }}" @selected((string) old('unidade_id') === (string) $unidade->id)>
                        {{ $unidade->nome }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('unidade_id')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="'Senha'" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'Confirmar Senha'" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-slate-600 hover:text-senac-blue rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-senac-orange" href="{{ route('login') }}">
                Ja possui cadastro?
            </a>

            <x-primary-button class="ms-4">
                Cadastrar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
