<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('¿Olvidaste tu contraseña? Coloca tu email para recibir un correo para reestablecer tu contraseña') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex justify-between my-5">
            <!-- Pasamos el href como parametro -->
            <x-link :href="route('login')">
                Iniciar sesión
            </x-link>
            <x-link :href="route('register')">
                Crear cuenta
            </x-link>

        </div>
        <div class="flex justify-end">
            <x-primary-button class="">
                {{ __('Recuperar contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
