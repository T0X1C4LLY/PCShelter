@props(['post'])

{{--<img src="{{ asset('storage/'.$post->thumbnail) }}" alt="Blog Post image" class="rounded-xl">--}}
<img src="https://picsum.photos/seed/{{ $post->id }}/500/400" alt="Blog Post illustration" class="rounded-xl">
