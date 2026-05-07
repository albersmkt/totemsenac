<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senac Registro - Totem</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                        <img src="{{ asset('images/logo.png') }}" alt="Senac Registro" class="h-full w-auto object-contain">
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
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-full bg-senac-orange text-white hover:bg-senac-orange/90 transition">Entrar</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-full border border-white text-white hover:bg-white/10 transition">Cadastrar</a>
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
    </div>

    <script>
        (function () {
            const INACTIVITY_LIMIT = 10 * 1000;
            let inactivityTimer = null;

            const resetTimer = () => {
                if (inactivityTimer) {
                    clearTimeout(inactivityTimer);
                }

                inactivityTimer = setTimeout(() => {
                    if (window.location.pathname !== '/') {
                        window.location.href = '/';
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
</body>
</html>
