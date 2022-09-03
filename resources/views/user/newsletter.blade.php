<x-main-layout>
    <x-user-setting heading="Newsletter">
        <div class="flex-col items-center w-full text-center truncate">
            <div class="text-yellow-500">
                @cannot('unsubscribe')
                    You are not a subscriber, please consider checking our newsletter
                @else
                    You are currently our subscriber, Thank You for Your support
                @endcannot
            </div>
            <div class="mt-10">
                <?php
                    $status = auth()->user()->hasPermissionTo('unsubscribe') ? 'unsubscribe' : 'subscribe';
                ?>
                <form method="POST" action="/{{ $status }}">
                    @csrf
                    <input id="email"
                           name="email"
                           type="hidden"
                           value="{{ auth()->user()->email }}"
                    >
                    @error('email')
                        <span class="text-xs text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                    <button type="submit"
                            class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8"
                    >
                        {{ $status }}
                    </button>
                </form>
            </div>
        </div>
    </x-user-setting>
</x-main-layout>
