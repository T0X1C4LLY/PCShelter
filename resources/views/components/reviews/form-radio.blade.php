@props(['name'])

<div class="mt-6 space-x-3 flex flex-rows">
    <div class="flex flex-row items-end mx-auto w-4/5">
        <div class="pr-3 w-1/3">
            <label title="{{ $slot }}">{{ ucfirst($name) }}</label>
        </div>
        <div class="grid grid-cols-10 w-7/12">
            @for ($i = 1; $i <= 10; $i++)
                <label>
                    <div>{{ $i }}</div>
                    <div class="px-2">
                        <input type="radio" name="{{ $name }}" value="{{ $i }}" {{ ($i === 5) ? 'checked' : '' }}>
                    </div>
                </label>
            @endfor
        </div>
        <x-reviews.form-radio-styles/>
        <div class="infolink px-1 w-1/12" title="{{ $slot }}"></div>
    </div>
</div>
