<x-breeze.breeze-layout>
    <!-- Session Status -->
    <x-breeze.auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-breeze.auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-breeze.label for="email" :value="__('Email')" />

            <x-breeze.input id="email"
                            class="block mt-1 w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-breeze.label for="password" :value="__('Password')" />

            <x-breeze.input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
            />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       name="remember"
                >
                <span class="ml-2 text-sm text-yellow-100 ">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-yellow-100 hover:text-yellow-300"
                   href="{{ route('password.request') }}"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-breeze.button class="ml-3">
                {{ __('Log in') }}
            </x-breeze.button>
        </div>
    </form>
</x-breeze.breeze-layout>
