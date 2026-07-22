<x-guest-layout>
    <x-slot name="title">Nueva contrasena | Somos Peru Olleros</x-slot>
    <x-slot name="heading">Nueva contrasena</x-slot>
    <x-slot name="subheading">Define una clave segura para volver a ingresar.</x-slot>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="campaign-label" for="email">Correo electronico</label>
            <input id="email" class="campaign-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
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

        <button class="campaign-button-primary w-full py-4" type="submit">Restablecer contrasena</button>
    </form>
</x-guest-layout>
