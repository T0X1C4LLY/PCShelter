@props(['heading'])

<section class="py-8 max-w-5xl mx-auto">
    <h1 class="text-lg font-bold mb-8 pb-2 border-b text-yellow-500">
        {{ $heading }}
    </h1>
    <div class="flex">
        <aside class="w-32 flex-shrink-0 text-yellow-100">
            <ul>
                <li>
                    <a
                        {{ request()->is('user/account') ? '' : 'href=/user/account'}}
                        class="{{ request()->is('user/account') ? 'text-yellow-500' : 'hover:text-yellow-300' }}"
                    >
                        Account
                    </a>
                </li>
                @creator
                    <li>
                        <a
                            {{ request()->is('user/posts') ? '' : 'href=/user/posts'}}
                            class="{{ request()->is('user/posts') ? 'text-yellow-500' : 'hover:text-yellow-300' }}"
                        >
                            Posts
                        </a>
                    </li>
                    <li>
                        <a
                            {{ request()->is('user/posts/create') ? '' : 'href=/user/posts/create'}}
                            class="{{ request()->is('user/posts/create') ? 'text-yellow-500' : 'hover:text-yellow-300' }}"
                        >
                            New Post
                        </a>
                    </li>
                @endcreator
                <li>
                    <a
                        {{ request()->is('user/comments') ? '' : 'href=/user/comments'}}
                        class="{{ request()->is('user/comments') ? 'text-yellow-500' : 'hover:text-yellow-300' }}"
                    >
                        Comments
                    </a>
                </li>
                <li>
                    <a
                        {{ request()->is('user/security') ? '' : 'href=/user/security'}}
                        class="{{ request()->is('user/security') ? 'text-yellow-500' : 'hover:text-yellow-300' }}"
                    >
                        Security
                    </a>
                </li>
            </ul>
        </aside>
        <main class="flex-1 max-w-4xl">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>
</section>
