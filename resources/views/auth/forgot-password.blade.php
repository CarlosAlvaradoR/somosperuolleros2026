<x-guest-layout>
    <x-slot name="title">Recuperar contrasena | Somos Peru Olleros</x-slot>
    <x-slot name="heading">Recuperar acceso</x-slot>
    <x-slot name="subheading">Te enviaremos un enlace para crear una nueva contrasena.</x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label class="campaign-label" for="email">Correo electronico</label>
            <input id="email" class="campaign-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="tu@ejemplo.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button class="campaign-button-primary w-full py-4" type="submit">Enviar enlace de recuperacion</button>
    </form>
</x-guest-layout>
