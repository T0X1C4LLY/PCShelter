<x-main-layout>

    @include ('posts._header')

    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($posts->count())
            <x-post.post-grid :posts="$posts"/>

            {{ $posts->links() }}
        @else
            <p class="text-center text-yellow-200">
                No posts yet. Please check back later.
            </p>
        @endif
    </main>

</x-main-layout>

