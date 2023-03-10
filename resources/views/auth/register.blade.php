<x-breeze.breeze-layout>

    <x-breeze.auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-breeze.label for="name" :value="__('Name')" />

            <x-breeze.input id="name"
                            class="block mt-1 w-full"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
            />
        </div>

        <div class="mt-4">
            <x-breeze.label for="username" :value="__('Username')" />

            <x-breeze.input id="username"
                            class="block mt-1 w-full"
                            type="text"
                            name="username"
                            :value="old('username')"
                            required
            />
        </div>

        <div class="mt-4">
            <x-breeze.label for="email" :value="__('Email')" />

            <x-breeze.input id="email"
                            class="block mt-1 w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
            />
        </div>

        <div class="mt-4">
            <x-breeze.label for="password" :value="__('Password')" />

            <x-breeze.input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
            />
        </div>

        <div class="mt-4">
            <x-breeze.label for="password_confirmation" :value="__('Confirm Password')" />

            <x-breeze.input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            required
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-yellow-100 hover:text-yellow-300" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-breeze.button class="ml-4">
                {{ __('Register') }}
            </x-breeze.button>
        </div>
    </form>
</x-breeze.breeze-layout>
