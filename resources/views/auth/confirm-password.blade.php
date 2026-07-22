<x-guest-layout>
    <x-slot name="title">Confirmar contrasena | Somos Peru Olleros</x-slot>
    <x-slot name="heading">Confirma tu acceso</x-slot>
    <x-slot name="subheading">Esta zona es segura. Confirma tu contrasena para continuar.</x-slot>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <div>
            <label class="campaign-label" for="password">Contrasena</label>
            <input id="password" class="campaign-input" type="password" name="password" required autocomplete="current-password" placeholder="********">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button class="campaign-button-primary w-full py-4" type="submit">Confirmar</button>
    </form>
</x-guest-layout>
