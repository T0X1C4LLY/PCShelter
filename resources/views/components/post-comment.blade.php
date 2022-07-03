@props(['comment'])
<x-panel class="bg-gray-800">
    <article class="flex space-x-4 text-yellow-200">
        <div class="flex-shrink-0">
            <img src="https://i.pravatar.cc/60?u={{ $comment->user_id }}" alt="" width="60" height="60" class="rounded-xl">
        </div>
        <div>
            <header class="mb-4 text-yellow-500">
                <h3 class="font-bold">{{ $comment->author->username }}</h3>
                <p class="text-xs text-yellow-400">
                    Posted
                    <time>{{ $comment->created_at->format('F j, Y, g:i a') }}</time>
                </p>
            </header>
            <p>
                {{ $comment->body }}
            </p>
        </div>
    </article>
</x-panel>
