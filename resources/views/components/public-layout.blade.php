<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'Somos Peru Olleros') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body x-data="{ menuOpen: false, footballModal: false, chatOpen: false }" class="min-h-screen bg-background text-on-surface">
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm" x-show="footballModal" x-cloak x-transition>
            <div class="relative max-h-[90vh] w-full max-w-xl overflow-y-auto rounded-[32px] bg-surface shadow-2xl" x-on:click.outside="footballModal = false">
                <button class="absolute right-6 top-6 flex h-10 w-10 items-center justify-center rounded-full text-on-surface-variant transition hover:bg-surface-variant" type="button" x-on:click="footballModal = false" aria-label="Cerrar">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <div class="space-y-8 p-8 md:p-12">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 rounded-full bg-secondary-fixed px-3 py-1 text-[12px] font-semibold uppercase tracking-wider text-secondary">
                            <span class="material-symbols-outlined text-[16px]">stars</span>
                            Copa Olleros 2024
                        </div>
                        <h2 class="font-headline text-[32px] font-bold leading-[1.2] text-primary md:text-[40px]">Inscripción al Campeonato Relámpago</h2>
                        <p class="text-on-surface-variant">Completa los datos de tu equipo para participar en el gran evento deportivo del distrito.</p>
                    </div>

                    <form class="space-y-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="campaign-label">Nombre del Equipo</label>
                                <input class="campaign-input bg-white" placeholder="Ej. Los Guerreros de Olleros" type="text">
                            </div>
                            <div>
                                <label class="campaign-label">Nombre del Delegado</label>
                                <input class="campaign-input bg-white" placeholder="Nombre completo" type="text">
                            </div>
                        </div>
                        <div>
                            <label class="campaign-label">Teléfono de Contacto</label>
                            <input class="campaign-input bg-white" placeholder="999 999 999" type="tel">
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-outline-variant pb-2">
                                <h4 class="flex items-center gap-2 font-headline text-[18px] font-semibold text-primary">
                                    <span class="material-symbols-outlined text-secondary">groups</span>
                                    Lista de Jugadores
                                </h4>
                                <button class="flex items-center gap-1 text-[12px] font-semibold uppercase tracking-wide text-secondary hover:underline" type="button">
                                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                    Agregar Jugador
                                </button>
                            </div>
                            <div class="grid grid-cols-12 gap-3">
                                <input class="col-span-7 rounded-lg border-outline-variant px-4 py-2 text-sm" placeholder="Nombre del Jugador" type="text">
                                <input class="col-span-5 rounded-lg border-outline-variant px-4 py-2 text-sm" placeholder="DNI" type="text">
                            </div>
                        </div>
                        <button class="w-full rounded-xl bg-primary py-4 text-[14px] font-semibold tracking-[0.05em] text-on-primary transition hover:bg-secondary" type="button">Registrar Equipo</button>
                    </form>
                </div>
            </div>
        </div>

        <header class="fixed left-0 right-0 top-0 z-50 h-20 bg-surface/80 shadow-[0px_10px_40px_rgba(33,68,139,0.06)] backdrop-blur-md">
            <div class="mx-auto flex h-full w-full max-w-[1200px] items-center justify-between px-5 md:px-6">
                <x-campaign-logo />

                <nav class="hidden items-center gap-6 md:flex lg:gap-8">
                    <a class="text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#biografia">Quién es</a>
                    <a class="text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#plan">Plan de Gobierno</a>
                    <a class="text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#regidores">Regidores</a>
                    <a class="text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-surface-variant transition hover:text-secondary" href="{{ route('landing') }}#contacto">Contacto</a>
                    <button class="group relative flex items-center gap-1 text-[14px] font-bold leading-[1.2] tracking-[0.05em] text-secondary transition hover:text-primary" type="button" x-on:click="footballModal = true">
                        <span class="material-symbols-outlined text-[18px]">sports_soccer</span>
                        Copa Olleros
                        <span class="absolute -right-3 -top-3 rounded-full bg-primary px-1.5 py-0.5 text-[9px] font-bold uppercase text-on-primary">Nuevo</span>
                    </button>
                </nav>

                <div class="hidden items-center gap-4 md:flex">
                    @auth
                        <a class="px-4 text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-primary transition hover:text-secondary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="px-4 text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-primary transition hover:text-secondary" href="{{ route('login') }}">Iniciar Sesión</a>
                    @endauth
                    <a class="rounded-lg bg-primary px-6 py-2.5 text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-on-primary transition hover:bg-secondary" href="{{ route('landing') }}#sumate">Súmate</a>
                </div>

                <button type="button" class="rounded-lg p-2 text-primary md:hidden" x-on:click="menuOpen = ! menuOpen" aria-label="Abrir menú">
                    <span class="material-symbols-outlined" x-text="menuOpen ? 'close' : 'menu'"></span>
                </button>
            </div>

            <div class="border-t border-outline-variant/20 bg-surface px-5 py-5 lg:hidden" x-show="menuOpen" x-transition>
                <nav class="campaign-container flex flex-col gap-4 font-semibold text-on-surface-variant">
                    <a href="{{ route('landing') }}#biografia">Quién es</a>
                    <a href="{{ route('landing') }}#plan">Plan de Gobierno</a>
                    <a href="{{ route('landing') }}#regidores">Regidores</a>
                    <a href="{{ route('landing') }}#contacto">Contacto</a>
                    <button class="text-left text-secondary" type="button" x-on:click="footballModal = true; menuOpen = false">Copa Olleros</button>
                    @auth
                        <a class="text-primary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="text-primary" href="{{ route('login') }}">Iniciar Sesión</a>
                    @endauth
                    <a class="campaign-button-primary" href="{{ route('landing') }}#sumate">Súmate</a>
                </nav>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
            <div class="mb-4 hidden w-80 overflow-hidden rounded-3xl border border-outline-variant/30 bg-surface shadow-2xl md:w-96" x-show="chatOpen" x-transition>
                <div class="flex items-center justify-between bg-primary p-4 text-on-primary">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20">
                            <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                        </div>
                        <span class="font-headline text-[16px] font-semibold">Asistente Virtual</span>
                    </div>
                    <button class="rounded-full p-1 hover:bg-white/10" type="button" x-on:click="chatOpen = false" aria-label="Cerrar chat">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="max-h-[400px] space-y-4 overflow-y-auto p-6">
                    <div class="rounded-2xl rounded-tl-none bg-surface-container-low p-4 text-on-surface-variant">
                        ¡Hola! Soy el asistente de Mirko Cacha. ¿En qué puedo ayudarte hoy?
                    </div>
                    <div class="space-y-2">
                        <p class="ml-1 text-[14px] font-semibold uppercase tracking-[0.05em] text-on-surface-variant">Preguntas Frecuentes</p>
                        <button class="flex w-full items-center justify-between rounded-xl border border-outline-variant p-3 text-left transition hover:border-primary hover:bg-primary/5" type="button"><span>Plan de Gobierno</span><span class="material-symbols-outlined text-primary">chevron_right</span></button>
                        <button class="flex w-full items-center justify-between rounded-xl border border-outline-variant p-3 text-left transition hover:border-primary hover:bg-primary/5" type="button"><span>Cómo sumarme</span><span class="material-symbols-outlined text-primary">chevron_right</span></button>
                        <button class="flex w-full items-center justify-between rounded-xl border border-outline-variant p-3 text-left transition hover:border-primary hover:bg-primary/5" type="button"><span>Lugares de votación</span><span class="material-symbols-outlined text-primary">chevron_right</span></button>
                    </div>
                </div>
                <div class="border-t border-outline-variant/20 bg-surface-container-lowest p-4">
                    <div class="relative">
                        <input class="w-full rounded-full border-outline-variant px-4 py-2 focus:border-primary focus:ring-primary/20" placeholder="Escribe tu mensaje..." type="text">
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 text-primary" type="button" aria-label="Enviar">
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-3 rounded-2xl border border-outline-variant/20 bg-white px-4 py-2 shadow-lg" x-show="! chatOpen" x-transition>
                <p class="text-[14px] font-semibold leading-[1.2] tracking-[0.05em] text-primary">¿Tienes dudas? ¡Pregúntame!</p>
            </div>
            <button class="flex h-16 w-16 items-center justify-center rounded-full bg-primary text-on-primary shadow-2xl transition hover:scale-110 hover:bg-secondary active:scale-95" type="button" x-on:click="chatOpen = ! chatOpen" aria-label="Abrir chat">
                <span class="material-symbols-outlined text-[32px]">chat</span>
            </button>
        </div>

        <footer class="border-t border-outline-variant/30 bg-surface-container-low">
            <div class="campaign-container grid gap-10 py-16 md:grid-cols-[1.4fr_1fr_1fr]">
                <div class="space-y-5">
                    <x-campaign-logo class="[&>span:last-child]:text-xl" />
                    <p class="max-w-md text-on-surface-variant">
                        Agua, chacra y futuro para Olleros. Una campaña construida con transparencia, trabajo comunal y servicio.
                    </p>
                </div>
                <div>
                    <h3 class="mb-4 font-headline text-lg font-bold text-primary">Enlaces</h3>
                    <div class="flex flex-col gap-3 text-on-surface-variant">
                        <a class="hover:text-secondary" href="{{ route('landing') }}#plan">Propuestas</a>
                        <a class="hover:text-secondary" href="{{ route('landing') }}#transparencia">Transparencia</a>
                        <a class="hover:text-secondary" href="{{ route('landing') }}#sumate">Súmate</a>
                    </div>
                </div>
                <div>
                    <h3 class="mb-4 font-headline text-lg font-bold text-primary">Contacto</h3>
                    <div class="space-y-3 text-on-surface-variant">
                        <p>Jr. Libertad 123, Plaza de Armas de Olleros</p>
                        <p>contacto@mirkocacha.pe</p>
                        <p>+51 987 654 321</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-outline-variant/20 py-5 text-center text-sm text-on-surface-variant">
                © 2024 Somos Peru Olleros. Todos los derechos reservados.
            </div>
        </footer>
    </body>
</html>
