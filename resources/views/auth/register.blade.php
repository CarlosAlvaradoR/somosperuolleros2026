<x-guest-layout>
    <x-slot name="title">Registro | Somos Peru Olleros</x-slot>
    <x-slot name="heading">Crea tu cuenta</x-slot>
    <x-slot name="subheading">Un espacio para colaborar con la campana y seguir sus avances.</x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label class="campaign-label" for="name">Nombre completo</label>
            <input id="name" class="campaign-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Juan Perez">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label class="campaign-label" for="email">Correo electronico</label>
            <input id="email" class="campaign-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="correo@ejemplo.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="campaign-label" for="password">Contrasena</label>
            <input id="password" class="campaign-input" type="password" name="password" required autocomplete="new-password" placeholder="********">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="campaign-label" for="password_confirmation">Confirmar contrasena</label>
            <input id="password_confirmation" class="campaign-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="********">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button class="campaign-button-primary w-full py-4" type="submit">Registrarme</button>

        <div class="border-t border-outline-variant/30 pt-6 text-center text-on-surface-variant">
            Ya tienes cuenta?
            <a class="font-bold text-primary hover:underline" href="{{ route('login') }}">Inicia sesion</a>
        </div>
    </form>
</x-guest-layout>
