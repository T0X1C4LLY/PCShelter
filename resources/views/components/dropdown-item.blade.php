@props(['active' => false])

@php
    $classes = 'block text-left px-3 text-sm leading-6 hover:bg-yellow-500 focus:bg-yellow-500 hover:text-white focus:text-white';

	if ($active) {
        $classes .= ' bg-yellow-500 text-white pointer-events-none';
	} else {
        $classes .= ' text-yellow-500';
	}
@endphp
<a {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</a>
