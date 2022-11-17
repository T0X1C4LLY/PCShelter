@props(['post'])

<article
    {{ $attributes->merge(['class' => 'transition-colors duration-200 hover:bg-gray-800 border border-yellow border-opacity-0 hover:border-opacity-5 rounded-xl']) }}>
    <div class="py-6 px-5 h-full flex flex-col">
        <div class="h-fit">
            <x-post.post-card-image :post="$post"/>
        </div>
        <div class="mt-8 flex flex-col justify-between text-yellow-100 flex-auto">
            <div>
                <x-post.post-card-header :post="$post"/>

                <div class="text-sm mt-4 space-y-4">
                    {!! $post['excerpt'] !!}
                </div>
            </div>
            <x-post.post-card-footer :post="$post"/>
        </div>
    </div>
</article>
