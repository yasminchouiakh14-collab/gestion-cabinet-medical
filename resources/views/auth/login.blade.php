<x-guest-layout>
    <!-- Visual Context for Type -->
    @if(request('type') == 'admin')
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-emerald-600">Connexion Administrateur / Médecin</h2>
            <p class="text-sm text-gray-500 mt-1">Gérez le cabinet médical</p>
        </div>
    @elseif(request('type') == 'patient' || !request()->has('type'))
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-blue-600">Connexion Patient</h2>
            <p class="text-sm text-gray-500 mt-1">Prenez et gérez vos rendez-vous</p>
        </div>
    @endif

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if(request('type') == 'patient' || !request()->has('type'))
            <div class="mt-6 text-center text-sm text-gray-600">
                Vous n'avez pas de compte ? 
                <a href="{{ route('register') }}" class="underline font-semibold text-blue-600 hover:text-blue-800">Inscrivez-vous ici</a>
            </div>
        @endif
    </form>
</x-guest-layout>
