@props(['post'])

<img src="{{ (!is_null($post['thumbnail']) && file_exists(public_path('storage/'.$post['thumbnail']))) ? asset('storage/'.$post['thumbnail']) : 'https://picsum.photos/seed/' . $post['id'] . '/500/400' }}"
     alt="Blog Post image"
     class="rounded-xl"
>
