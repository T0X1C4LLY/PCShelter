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
        <style>
            .infolink:before
            {
                content: '?';
                display: inline-block;
                font-family: sans-serif;
                font-weight: bold;
                text-align: center;
                width: 1.8ex;
                height: 1.8ex;
                font-size: 1.4ex;
                line-height: 1.8ex;
                border-radius: 1.2ex;
                margin-right: 4px;
                padding: 1px;
                color: red;
                background: white;
                border: 1px solid red;
            }

            .infolink:hover:before
            {
                color: white;
                background: red;
                border-color: white;
                text-decoration: none;
            }
        </style>
        <div class="infolink px-1 w-1/12" title="{{ $slot }}"></div>
    </div>
</div>
