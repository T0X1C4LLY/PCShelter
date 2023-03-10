<x-breeze.breeze-layout>
    <div class="mb-4 text-sm text-yellow-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <x-breeze.auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <x-breeze.label for="password" :value="__('Password')" />

            <x-breeze.input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
            />
        </div>

        <div class="flex justify-end mt-4">
            <x-breeze.button>
                {{ __('Confirm') }}
            </x-breeze.button>
        </div>
    </form>
</x-breeze.breeze-layout>
