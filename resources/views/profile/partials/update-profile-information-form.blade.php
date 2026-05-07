<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informações do perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Atualize as informações do seu perfil e email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="'Nome'" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Seu email ainda nao foi verificado.

                        <button form="send-verification" class="underline text-sm text-slate-600 hover:text-senac-blue rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-senac-orange">
                            Clique aqui para reenviar o email de verificacao.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Um novo link de verificacao foi enviado para o seu email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="photo" :value="__('Foto de Perfil')" />
            <input id="photo" name="photo" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-700" />
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />

            @if ($user->photo)
                <div class="mt-3 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de perfil" class="h-16 w-16 rounded-full object-cover">
                    <label class="text-sm text-gray-600 flex items-center gap-2">
                        <input type="checkbox" name="remove_photo" value="1">
                        Remover foto
                    </label>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Salvar</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Salvo.</p>
            @endif
        </div>
    </form>
</section>
