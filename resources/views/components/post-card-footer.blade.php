@props(['post'])
<footer class="flex justify-between items-center mt-8">
    <div class="flex items-center text-sm">
        <img src="https://i.pravatar.cc/75?img={{ $post->author->id }}" alt="avatar" class="rounded-xl">
        <div class="ml-3">
            <h5 class="font-bold text-yellow-500">
                <a href="/?author={{ $post->author->username }}">{{ $post->author->name }}</a>
            </h5>
        </div>
    </div>

    <div class="hidden lg:block">
        <a href="posts/{{ $post->slug }}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 text-yellow-700"
        >Read More</a>
    </div>
</footer>
