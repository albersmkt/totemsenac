<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Obrigado por se cadastrar. Para continuar, confirme seu email pelo link enviado. Se nao recebeu, podemos reenviar.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Um novo link de verificacao foi enviado para o email cadastrado.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Reenviar email de verificacao
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-slate-600 hover:text-senac-blue rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-senac-orange">
                Sair
            </button>
        </form>
    </div>
</x-guest-layout>
