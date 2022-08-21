@props(['property', 'type' => 'text'])

<div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 min-w-max">
    <form method="POST" action="/user/change/{{ $property }}" class="text-sm w-full flex">
        @csrf
        <div class="w-5/12 my-auto min-w-min">
            <input id="{{ $property }}"
                   name="{{ $property }}"
                   type="{{ $type }}"
                   placeholder="{{ auth()->user()->$property ?? ''}}"
                   class="py-1 pl-2 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl w-full truncate"
            >
        </div>
        <div class="w-4/12 my-auto text-left">
            @error($property)
                <span class="text-xs text-red-500 px-1">
                        {{ $message }}
                </span>
            @enderror
        </div>
        <div class="w-3/12 my-auto">
            <button type="submit"
                    class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 rounded-full text-xs font-semibold text-white uppercase px-2 py-3 text-center w-full truncate"
            >
                Change {{ $property }}
            </button>
        </div>
    </form>
</div>
