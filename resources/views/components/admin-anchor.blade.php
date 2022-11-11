@props(['url', 'value'])

<td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium text-yellow-600">
    <a href="/{{ $url }}?order={{ request()->fullUrlIs("*order=DESC*") ? 'ASC' : 'DESC' }}&by={{ Str::snake($value) }}&{{ http_build_query(request()->except(['order', 'by'])) }}">
        {{ ucfirst($value) }}
    </a>
</td>
