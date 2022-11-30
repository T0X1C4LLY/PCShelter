<x-breeze.breeze-layout>
    <div class="mb-4 text-sm text-yellow-100">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-breeze.auth-session-status class="mb-4" :status="session('status')" />
    <x-breeze.auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-breeze.label for="login" :value="__('Email\Username')" />

            <x-breeze.input id="login"
                            class="block mt-1 w-full"
                            type="text"
                            name="login"
                            :value="old('login')"
                            required
                            autofocus
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-breeze.button>
                {{ __('Email Password Reset Link') }}
            </x-breeze.button>
        </div>
    </form>
</x-breeze.breeze-layout>
