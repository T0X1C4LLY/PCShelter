@props(['post'])

<article
    {{ $attributes->merge( ['class' => 'transition-colors duration-300 hover:bg-gray-800 border border-yellow border-opacity-0 hover:border-opacity-5 rounded-xl']) }}>
    <div class="py-6 px-5 lg:flex">
        <div class="flex-1 lg:mr-8">
            <x-post.post-card-image :post="$post"/>
        </div>
        <div class="flex-1 flex flex-col justify-between text-yellow-100">
            <x-post.post-card-header :post="$post" class="mt-8 lg:mt-0"/>

            <div class="text-sm mt-2 space-y-4">
                {!! $post['excerpt'] !!}
            </div>

            <x-post.post-card-footer :post="$post"/>
        </div>
    </div>
</article>
