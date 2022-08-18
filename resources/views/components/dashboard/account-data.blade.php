@props(['dataType', 'dataToDisplay'])

<div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 flex">
    <div class="w-1/2 text-right pr-1">
        {{ $dataType }}
    </div>
    <div class="w-1/2 text-yellow-400 text-left pl-1 truncate">
        {{ $dataToDisplay}}
    </div>
</div>
