<header class="max-w-xl mx-auto mt-20 text-center">
    <h1 class="text-4xl text-white">
        Latest <span class="text-yellow-500">PCShelter</span> News
    </h1>

    <div class="space-y-2 lg:space-y-0 lg:space-x-4 mt-4">
        <div class="relative lg:inline-flex bg-gray-100 rounded-xl">
            <x-category-dropdown :categories="$categories" :currentCategory="$currentCategory"/>
        </div>
        <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl px-3 py-2">
            <form class="w-full" method="GET" action="/">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <input type="text"
                       name="search"
                       placeholder="Find something"
                       class="bg-transparent placeholder-yellow-400 font-semibold text-sm text-yellow-500 w-full px-1"
                       value="{{ request('search') }}"
                >
            </form>
        </div>
    </div>
</header>
