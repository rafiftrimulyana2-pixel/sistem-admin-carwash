<x-guest-layout>
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
        <div class="text-center mt-4 mb-4">
            <p class="text-center text-[10px] text-gray-400 uppercase tracking-widest mt- mb-4">Premium Service & Reservation</p>
        </div>

        <button type="submit"
            style="background-color: #2563eb; width: 100%; color: white; padding: 12px 0; border-radius: 8px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; transition: 0.3s;"
            onmouseover="this.style.backgroundColor='#60a5fa'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            onmousedown="this.style.backgroundColor='#93c5fd'"
            onmouseup="this.style.backgroundColor='#60a5fa'">
            LOG IN
        </button>

        <div class="text-center mt-2">
            @if (Route::has('password.request'))
                <a class="mt-4 underline text-xs text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
