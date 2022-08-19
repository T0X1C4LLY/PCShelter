@props(['property', 'type' => 'text'])

<div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1">
    <form method="POST" action="/user/change/{{ $property }}" class="text-sm w-full flex">
        @csrf
        <div class="w-3/4 flex">
            <input id="{{ $property }}"
                   name="{{ $property }}"
                   type="{{ $type }}"
                   placeholder="{{ auth()->user()->$property ?? ''}}"
                   class="py-2 lg:py-0 pl-4 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl"
            >
            @error($property)
            <span class="text-xs text-red-500 py-3 px-1">
                {{ $message }}
            </span>
            @enderror
        </div>
        <div class="w-1/4">
            <div class="w-full">
                <button type="submit"
                        class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 rounded-full text-xs font-semibold text-white uppercase py-3 px-8 text-center w-full"
                >
                    Change {{ $property }}
                </button>
            </div>
        </div>
    </form>
</div>
