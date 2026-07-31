<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Somos Peru Olleros') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background text-on-surface antialiased">
        <div class="flex min-h-screen" x-data="{ sidebar: false }">
            <aside class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-outline-variant/30 bg-surface-container-lowest transition lg:static lg:translate-x-0" :class="{ 'translate-x-0': sidebar }">
                <div class="flex h-20 items-center border-b border-outline-variant/20 px-6">
                    <x-campaign-logo class="[&>span:last-child]:text-lg" />
                </div>

                <nav class="flex-1 space-y-2 px-4 py-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg bg-primary-fixed px-4 py-3 font-semibold text-primary">
                        <span class="material-symbols-outlined">dashboard</span>
                        Inicio
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 font-semibold text-on-surface-variant transition hover:bg-surface-container">
                        <span class="material-symbols-outlined">description</span>
                        Propuestas
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 font-semibold text-on-surface-variant transition hover:bg-surface-container">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        Transparencia
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-3 font-semibold text-on-surface-variant transition hover:bg-surface-container">
                        <span class="material-symbols-outlined">settings</span>
                        Configuracion
                    </a>
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 font-semibold text-on-surface-variant transition hover:bg-surface-container">
                        <span class="material-symbols-outlined">public</span>
                        Ver landing
                    </a>
                </nav>

                <div class="absolute bottom-0 left-0 right-0 border-t border-outline-variant/20 p-6">
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-outline">Campana 2026</p>
                </div>
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                <header class="sticky top-0 z-40 flex h-20 items-center justify-between border-b border-outline-variant/20 bg-surface/85 px-5 backdrop-blur-md md:px-8">
                    <div class="flex items-center gap-3">
                        <button type="button" class="rounded-lg p-2 text-primary lg:hidden" x-on:click="sidebar = ! sidebar">
                            <span class="material-symbols-outlined">menu</span>
                        </button>
                        @isset($header)
                            {{ $header }}
                        @else
                            <h1 class="font-headline text-2xl font-extrabold text-primary">Panel de campana</h1>
                        @endisset
                    </div>

                    <div class="flex items-center gap-4">
                        <button class="relative rounded-full p-2 text-on-surface-variant transition hover:bg-surface-container" type="button">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-secondary"></span>
                        </button>
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-bold text-on-surface">{{ Auth::user()->name ?? 'Admin Mirko' }}</p>
                            <p class="text-xs text-on-surface-variant">Coordinador General</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-lg bg-primary px-4 py-2 text-sm font-bold text-on-primary transition hover:bg-secondary" type="submit">Salir</button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 p-5 md:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
