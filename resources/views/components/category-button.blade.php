@props(['category'])

<a href="/?category={{ $category->slug }}"
   class="px-3 py-1 border border-yellow-300 rounded-full text-yellow-300 text-xs uppercase font-semibold"
   style="font-size: 10px"
>
    {{ $category->name }}
</a>
