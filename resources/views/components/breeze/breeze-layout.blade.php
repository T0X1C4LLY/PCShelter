<x-guest-layout>
    <x-breeze.auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-breeze.application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        {{ $slot }}
    </x-breeze.auth-card>
</x-guest-layout>
