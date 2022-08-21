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
                        {{ request()->is('admin/posts') ? '' : 'href=/admin/posts'}}
                        class="{{ request()->is('admin/posts') ? 'text-yellow-500' : 'hover:text-yellow-300' }}"
                    >
                        All Posts
                    </a>
                </li>
            </ul>
        </aside>
        <main class="flex-1">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>
</section>
