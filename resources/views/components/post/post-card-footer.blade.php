@props(['post'])

<footer class="flex justify-between items-center mt-8 w-full">
    <div class="flex items-center text-sm w-3/5">
        <img src="https://i.pravatar.cc/75?img={{ $post['username'] }}" alt="avatar" class="rounded-xl">
        <div class="ml-3">
            <h5 class="font-bold text-yellow-500">
                <a href="/?author={{ $post['username'] }}&{{ http_build_query(request()->all()) }}">
                    {{ $post['name'] }}
                </a>
            </h5>
        </div>
    </div>

    <div class="hidden lg:block w-fit">
        <a href="posts/{{ $post['slug'] }}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 text-yellow-700"
        >
            Read More
        </a>
    </div>
</footer>
