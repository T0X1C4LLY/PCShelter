@props(['name'])

<label class="block mb-2 uppercase font-bold text-xs text-yellow-500"
       for="{{ $name }}"
>
    {{ ucwords($name) }}
</label>
