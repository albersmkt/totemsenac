<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @php
        $totemUnitId = \App\Support\UnitContext::resolveTotemUnitId(request());
        $totemUnitName = optional(\App\Models\Unidade::find($totemUnitId))->nome ?? 'Senac';
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $totemUnitName }} - Totem</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1055;
            display: none;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            outline: 0;
        }
        .modal.show {
            display: block;
        }
        .modal.fade .modal-dialog {
            transform: translateY(-24px);
            opacity: 0;
            transition: transform .2s ease-out, opacity .2s ease-out;
        }
        .modal.show .modal-dialog {
            transform: none;
            opacity: 1;
        }
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 1.75rem auto;
            max-width: 520px;
            padding: 0 .75rem;
        }
        .modal-dialog-centered {
            min-height: calc(100% - 3.5rem);
            display: flex;
            align-items: center;
        }
        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            border: 1px solid #dee2e6;
            border-radius: .75rem;
            background: #fff;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .2);
        }
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .modal-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
        }
        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 1rem;
        }
        .btn-close {
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            border: 0;
            background: transparent;
            border-radius: .375rem;
            opacity: .5;
            cursor: pointer;
            padding: .25em;
        }
        .btn-close::before {
            content: "\00d7";
            font-size: 1.35rem;
            line-height: 1;
            color: #334155;
        }
        .btn-close:hover {
            opacity: .8;
        }
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100vw;
            height: 100vh;
            background-color: #64748b;
        }
        .modal-backdrop.fade {
            opacity: 0;
            transition: opacity .15s linear;
        }
        .modal-backdrop.show {
            opacity: .55;
        }
        body.modal-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="min-h-screen flex flex-col">
        @php
            $active = fn (string $route) => request()->routeIs($route)
                ? 'bg-senac-orange text-white'
                : 'text-white/80 hover:text-white';
        @endphp

        <header class="sticky top-0 z-30 bg-senac-blue shadow-lg shadow-slate-900/10">
            <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between gap-6">
                <div class="flex items-center">
                    <div class="h-12 w-[180px] md:w-[210px] flex items-center overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ $totemUnitName }}" class="h-full w-auto object-contain">
                    </div>
                </div>
                <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold">
                    <a href="{{ route('totem.home') }}" class="px-4 py-2 rounded-full {{ $active('totem.home') }}">Inicio</a>
                    <a href="{{ route('totem.actions.index') }}" class="px-4 py-2 rounded-full {{ $active('totem.actions.*') }}">Ações</a>
                    <a href="{{ route('totem.events.index') }}" class="px-4 py-2 rounded-full {{ $active('totem.events.*') }}">Eventos</a>
                    <a href="{{ route('totem.projects.index') }}" class="px-4 py-2 rounded-full {{ $active('totem.projects.*') }}">Projeto Integrador</a>
                    <a href="{{ route('totem.entrepreneurs.index') }}" class="px-4 py-2 rounded-full {{ $active('totem.entrepreneurs.*') }}">Empreendedores</a>
                    <a href="{{ route('totem.courses') }}" class="px-4 py-2 rounded-full {{ $active('totem.courses') }}">Cursos</a>
                    <a href="{{ route('totem.bemestar') }}" class="px-4 py-2 rounded-full {{ $active('totem.bemestar') }}">Bem-estar</a>
                    <div class="border-l border-white/30 mx-2"></div>
                    @auth
                        <span class="px-4 py-2 text-white/80">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-full bg-senac-orange text-white hover:bg-senac-orange/90 transition">Sair</button>
                        </form>
                    @else
                        <button type="button" data-login-open class="px-4 py-2 rounded-full bg-senac-orange text-white hover:bg-senac-orange/90 transition">Entrar</button>
                        <button type="button" data-register-open class="px-4 py-2 rounded-full border border-white text-white hover:bg-white/10 transition">Cadastrar</button>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-1 max-w-6xl mx-auto w-full px-6 py-10">
            @yield('content')
        </main>

        <footer class="py-6 text-center text-xs text-slate-400">
            Toque para explorar. O totem volta automaticamente para a tela inicial em 45 segundos.
        </footer>

        @guest
            @php
                $requestedModal = request()->query('modal');
                $openRegisterModal = old('form_source') === 'register_modal'
                    || $requestedModal === 'register'
                    || $errors->has('name')
                    || $errors->has('unidade_id')
                    || $errors->has('password_confirmation');
                $openLoginModal = ! $openRegisterModal && (
                    old('form_source') === 'login_modal'
                    || $requestedModal === 'login'
                    || $errors->has('email')
                    || $errors->has('password')
                );
                $hasOpenModal = $openLoginModal || $openRegisterModal;
                $unidadesCadastro = \App\Models\Unidade::query()->orderBy('nome')->get();
            @endphp
            <div
                class="modal fade{{ $openLoginModal ? ' show' : '' }}"
                id="loginModal"
                tabindex="-1"
                aria-labelledby="loginModalLabel"
                aria-hidden="{{ $openLoginModal ? 'false' : 'true' }}"
                style="{{ $openLoginModal ? 'display:block;' : 'display:none;' }}"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="loginModalLabel">Entrar no sistema</h1>
                            <button type="button" class="btn-close" data-login-close aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <p class="text-sm text-slate-500 mb-5">Use seu email e senha para acessar o painel.</p>

                            @if (session('status'))
                                <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700 text-sm">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="form_source" value="login_modal">

                                <div>
                                    <label for="modal-email" class="text-sm font-semibold text-slate-700">Email</label>
                                    <input id="modal-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mt-1 w-full rounded-xl border-slate-200">
                                    @error('email')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="modal-password" class="text-sm font-semibold text-slate-700">Senha</label>
                                    <input id="modal-password" type="password" name="password" required autocomplete="current-password" class="mt-1 w-full rounded-xl border-slate-200">
                                    @error('password')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4 flex items-center gap-2">
                                    <input id="modal-remember_me" type="checkbox" class="rounded border-slate-300 text-senac-orange shadow-sm focus:ring-senac-orange" name="remember">
                                    <label for="modal-remember_me" class="text-sm text-slate-600">Lembrar-me</label>
                                </div>

                                <div class="mt-6 flex items-center justify-between gap-3">
                                    <a href="{{ route('password.request') }}" class="underline text-sm text-slate-600 hover:text-senac-blue">Esqueci minha senha</a>
                                    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold hover:bg-senac-orange/90">Entrar</button>
                                </div>

                                <div class="mt-4 text-sm text-slate-600">
                                    Ainda não tem conta?
                                    <button type="button" data-register-open class="underline hover:text-senac-blue">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="modal fade{{ $openRegisterModal ? ' show' : '' }}"
                id="registerModal"
                tabindex="-1"
                aria-labelledby="registerModalLabel"
                aria-hidden="{{ $openRegisterModal ? 'false' : 'true' }}"
                style="{{ $openRegisterModal ? 'display:block;' : 'display:none;' }}"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" id="registerModalLabel">Cadastro de aluno</h1>
                            <button type="button" class="btn-close" data-register-close aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <p class="text-sm text-slate-500 mb-5">Preencha os dados para criar sua conta no sistema.</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <input type="hidden" name="form_source" value="register_modal">

                                <div>
                                    <label for="modal-register-name" class="text-sm font-semibold text-slate-700">Nome</label>
                                    <input id="modal-register-name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="mt-1 w-full rounded-xl border-slate-200">
                                    @error('name')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="modal-register-email" class="text-sm font-semibold text-slate-700">Email</label>
                                    <input id="modal-register-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="mt-1 w-full rounded-xl border-slate-200">
                                    @error('email')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="modal-register-unidade" class="text-sm font-semibold text-slate-700">Unidade</label>
                                    <select id="modal-register-unidade" name="unidade_id" required class="mt-1 w-full rounded-xl border-slate-200">
                                        <option value="">Selecione</option>
                                        @foreach ($unidadesCadastro as $unidade)
                                            <option value="{{ $unidade->id }}" @selected((string) old('unidade_id') === (string) $unidade->id)>
                                                {{ $unidade->nome }} - {{ $unidade->cidade }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('unidade_id')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="modal-register-password" class="text-sm font-semibold text-slate-700">Senha</label>
                                    <input id="modal-register-password" type="password" name="password" required autocomplete="new-password" class="mt-1 w-full rounded-xl border-slate-200">
                                    @error('password')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="modal-register-password-confirmation" class="text-sm font-semibold text-slate-700">Confirmar senha</label>
                                    <input id="modal-register-password-confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 w-full rounded-xl border-slate-200">
                                    @error('password_confirmation')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-6 flex items-center justify-end">
                                    <button class="px-5 py-2 rounded-full bg-senac-orange text-white font-semibold hover:bg-senac-orange/90">Cadastrar</button>
                                </div>

                                <div class="mt-4 text-sm text-slate-600">
                                    Já possui cadastro?
                                    <button type="button" data-login-open class="underline hover:text-senac-blue">Entrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="modal-backdrop fade{{ $hasOpenModal ? ' show' : '' }}"
                id="globalModalBackdrop"
                style="{{ $hasOpenModal ? 'display:block;' : 'display:none;' }}"
            ></div>
        @endguest
    </div>

    <script>
        (function () {
            const INACTIVITY_LIMIT = 45 * 1000;
            const HOME_URL = "{{ route('totem.home') }}";
            let inactivityTimer = null;

            const resetTimer = () => {
                if (inactivityTimer) {
                    clearTimeout(inactivityTimer);
                }

                inactivityTimer = setTimeout(() => {
                    if (window.location.href !== HOME_URL) {
                        window.location.href = HOME_URL;
                    } else {
                        window.location.reload();
                    }
                }, INACTIVITY_LIMIT);
            };

            ['mousemove', 'mousedown', 'touchstart', 'keydown', 'scroll'].forEach((eventName) => {
                document.addEventListener(eventName, resetTimer, { passive: true });
            });

            window.addEventListener('load', resetTimer);
        })();
    </script>

    <script>
        (function () {
            const carousels = document.querySelectorAll('[data-carousel]');
            carousels.forEach((carousel) => {
                const track = carousel.querySelector('[data-carousel-track]');
                const prev = carousel.querySelector('[data-carousel-prev]');
                const next = carousel.querySelector('[data-carousel-next]');

                if (!track || !prev || !next) return;

                const scrollAmount = () => Math.max(track.clientWidth * 0.8, 280);

                prev.addEventListener('click', () => {
                    track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
                });

                next.addEventListener('click', () => {
                    track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
                });
            });
        })();
    </script>

    <script>
        (function () {
            const hero = document.querySelector('[data-hero]');
            if (!hero) return;

            const slides = Array.from(hero.querySelectorAll('[data-hero-slide]'));
            const dots = Array.from(hero.querySelectorAll('[data-hero-dot]'));
            const prev = hero.querySelector('[data-hero-prev]');
            const next = hero.querySelector('[data-hero-next]');

            if (slides.length <= 1) {
                if (prev) prev.classList.add('hidden');
                if (next) next.classList.add('hidden');
                if (dots.length) {
                    hero.querySelector('.hero-dots')?.classList.add('hidden');
                }
                return;
            }

            let index = 0;
            let timer = null;

            const setActive = (newIndex) => {
                index = (newIndex + slides.length) % slides.length;
                slides.forEach((slide, i) => {
                    slide.classList.toggle('is-active', i === index);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('is-active', i === index);
                });
            };

            const restartTimer = () => {
                if (timer) clearInterval(timer);
                timer = setInterval(() => {
                    setActive(index + 1);
                }, 8000);
            };

            prev?.addEventListener('click', () => {
                setActive(index - 1);
                restartTimer();
            });

            next?.addEventListener('click', () => {
                setActive(index + 1);
                restartTimer();
            });

            dots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    const target = Number(dot.getAttribute('data-hero-index') || '0');
                    setActive(target);
                    restartTimer();
                });
            });

            setActive(0);
            restartTimer();
        })();
    </script>

    <script>
        (function () {
            const modal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            const backdrop = document.getElementById('globalModalBackdrop');
            if (!modal || !registerModal || !backdrop) return;

            const openButtons = document.querySelectorAll('[data-login-open]');
            const registerOpenButtons = document.querySelectorAll('[data-register-open]');
            const closeButtons = modal.querySelectorAll('[data-login-close]');
            const registerCloseButtons = registerModal.querySelectorAll('[data-register-close]');
            const firstInput = document.getElementById('modal-email');
            const registerFirstInput = document.getElementById('modal-register-name');

            const showElement = (el) => {
                el.style.display = 'block';
                requestAnimationFrame(() => el.classList.add('show'));
            };

            const hideElement = (el) => {
                el.classList.remove('show');
                setTimeout(() => {
                    if (!el.classList.contains('show')) {
                        el.style.display = 'none';
                    }
                }, 180);
            };

            const isAnyOpen = () => modal.classList.contains('show') || registerModal.classList.contains('show');

            const openLoginModal = () => {
                registerModal.classList.remove('show');
                registerModal.style.display = 'none';
                showElement(modal);
                showElement(backdrop);
                modal.setAttribute('aria-hidden', 'false');
                registerModal.setAttribute('aria-hidden', 'true');
                document.body.classList.add('modal-open');
                setTimeout(() => firstInput?.focus(), 120);
            };

            const openRegisterModal = () => {
                modal.classList.remove('show');
                modal.style.display = 'none';
                showElement(registerModal);
                showElement(backdrop);
                registerModal.setAttribute('aria-hidden', 'false');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.add('modal-open');
                setTimeout(() => registerFirstInput?.focus(), 120);
            };

            const closeAllModals = () => {
                hideElement(modal);
                hideElement(registerModal);
                hideElement(backdrop);
                modal.setAttribute('aria-hidden', 'true');
                registerModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('modal-open');
            };

            openButtons.forEach((button) => button.addEventListener('click', openLoginModal));
            registerOpenButtons.forEach((button) => button.addEventListener('click', openRegisterModal));
            closeButtons.forEach((button) => button.addEventListener('click', closeAllModals));
            registerCloseButtons.forEach((button) => button.addEventListener('click', closeAllModals));
            backdrop.addEventListener('click', closeAllModals);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && isAnyOpen()) closeAllModals();
            });

            if (isAnyOpen()) {
                document.body.classList.add('modal-open');
            }
        })();
    </script>
</body>
</html>
