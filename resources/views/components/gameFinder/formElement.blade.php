@props(['name', 'array', 'isAllEnable' => true])

<div class="flex w-full">
    <div class="flex flex-cols justify-between border border-gray-500 rounded-xl mb-3 w-11/12">
        <div class="text-yellow-500 p-3 w-1/3">
            <label for="genre">{{ ucfirst($name) }}:</label>
        </div>
        <div class="w-2/3 mx-2" id="{{ $name }}Div">
            <select name="{{ $name }}[]" id="{{ $name }}"
                    class="w-full text-yellow-500 my-2 bg-gray-500 rounded-xl py-1 px-3 appearance-none cursor-pointer">
                @if ($isAllEnable)
                    <option value="all">All</option>
                @endif
                @foreach($array as $element)
                    <option value="{{ $element['name'] ?? $element }}">{{ ucfirst($element['name'] ?? $element) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="w-min mx-auto">
        <button type="button" onclick="add('{{ $name }}')" id="add{{ ucfirst($name) }}">
            <svg width="25" height="26" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" fill="red"/>
                <rect width="9" height="1" x="3.3" y="7.5" style="stroke-width:1;stroke:rgb(255,0,0)"/>
                <rect width="1" height="9" x="7.5" y="3.3" style="stroke-width:1;stroke:rgb(255,0,0)"/>
            </svg>
        </button>
        <button type="button" onclick="sub('{{ $name }}')" id="sub{{ ucfirst($name) }}" style="visibility: hidden">
            <svg width="25" height="25" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" fill="red"/>
                <rect width="9" height="1" x="3.3" y="7.5" style="stroke-width:1;stroke:rgb(255,0,0)"/>
            </svg>
        </button>
    </div>
</div>
