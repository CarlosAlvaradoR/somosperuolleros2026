<x-guest-layout>
    <x-slot name="title">Iniciar sesión | Somos Perú Olleros</x-slot>
    <x-slot name="heading">Bienvenido de nuevo</x-slot>
    <x-slot name="subheading">Accede a tu cuenta para continuar con el futuro.</x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label class="campaign-label" for="email">Correo electrónico</label>
            <input id="email" class="campaign-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@ejemplo.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="mb-2 flex items-center justify-between">
                <label class="block text-sm font-semibold uppercase tracking-wide text-on-surface-variant" for="password">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-primary hover:underline" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>
            <input id="password" class="campaign-input" type="password" name="password" required autocomplete="current-password" placeholder="********">

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary" name="remember">
                <span class="ms-2 text-sm text-on-surface-variant">Recordar mi sesión</span>
            </label>
        </div>

        <button class="campaign-button-primary w-full py-4" type="submit">Iniciar sesión</button>
    </form>
</x-guest-layout>
