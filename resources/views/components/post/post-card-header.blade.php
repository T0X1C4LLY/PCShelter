@props(['post'])
<header {{ $attributes->merge( ['class' => '']) }}>
    <div class="space-x-2">
        <x-category-button :category="$post->category"/>
    </div>

    <div class="mt-4">
        <h1 class="text-3xl">
            <a href="posts/{{ $post->slug }}">
                {{ $post->title }}
            </a>
        </h1>

        <span class="mt-2 block text-yellow-400 text-xs">
            Published
            <time>
                {{ $post->created_at->diffForHumans() }}
            </time>
        </span>
    </div>
</header>
