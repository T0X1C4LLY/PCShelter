<x-breeze.breeze-layout>

    <x-breeze.auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-breeze.label for="email" :value="__('Email')" />

            <x-breeze.input id="email"
                            class="block mt-1 w-full"
                            type="email"
                            name="email"
                            :value="old('email', $request->email)"
                            required
            />
        </div>

        <div class="mt-4">
            <x-breeze.label for="password" :value="__('Password')" />

            <x-breeze.input id="password"
                            class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required
                            autofocus
            />
        </div>

        <div class="mt-4">
            <x-breeze.label for="password_confirmation" :value="__('Confirm Password')" />

            <x-breeze.input id="password_confirmation"
                            class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            required
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-breeze.button>
                {{ __('Reset Password') }}
            </x-breeze.button>
        </div>
    </form>
</x-breeze.breeze-layout>
