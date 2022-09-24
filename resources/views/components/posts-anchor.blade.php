@props(['user', 'value'])

<td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium text-yellow-600">
    <a href="/{{ $user }}/posts?sort={{ request()->fullUrlIs("*&sort=DESC") ? 'ASC' : 'DESC' }}&by={{ Str::snake($value) }}&{{ http_build_query(request()->except(['by', 'sort'])) }}">
        {{ ucfirst($value) }}
    </a>
</td>