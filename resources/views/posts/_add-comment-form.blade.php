@auth
    <x-panel>
        <form method="POST" action="/posts/{{ $post->slug }}/comments">
            @csrf
            <header class="flex items-center">
                <img src="https://i.pravatar.cc/40?u={{ auth()->id() }}" alt="" width="40" height="40" class="rounded-full">
                <h2 class="ml-4 text-yellow-500">Want to participate?</h2>
            </header>

            <div class="mt-6">
                <textarea
                    name="body"
                    class="w-full text-sm focus:outline-none focus:ring px-1 text-yellow-200 bg-gray-800 resize-none"
                    cols="30"
                    rows="10"
                    placeholder="Quick, thing of something to say"
                    required></textarea>
                @error('body')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end mt-p pt-6 border-t border-gray-200">
                <x-form.button>Post</x-form.button>
            </div>

        </form>
    </x-panel>
@else
    <p class="font-semibold text-yellow-400">
        <a href="/register" class="hover:underline text-yellow-500">Register</a> or <a href="/login" class="hover:underline text-yellow-500">Log in</a> to leave a comment
    </p>
@endauth
