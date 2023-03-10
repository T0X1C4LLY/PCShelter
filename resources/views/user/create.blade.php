<x-main-layout>
    <x-user-setting heading="Publish New Post">
        <script src="https://use.fontawesome.com/3a2eaf6206.js"></script>
        <form method="POST" action="/user/posts" enctype="multipart/form-data">
            @csrf
            <x-form.input name="title"/>
            <x-form.input name="slug"/>
            <x-form.input name="thumbnail" type="file"/>
            <x-form.textarea name="excerpt"/>
            <x-form.textarea name="body"/>

            <x-form.field>
                <x-form.label name="category"/>
                <select name="category_id" id="category_id" class="text-yellow-600">
                    @foreach ($categories as $category)
                        <option
                            value="{{ $category['id'] }}"
                            {{ old('category_id') == $category['id'] ? 'selected' : '' }}
                        >
                            {{ ucwords($category['name']) }}
                        </option>
                    @endforeach
                </select>
                <x-form.error name="category"/>
            </x-form.field>
            <x-form.button>Publish</x-form.button>
        </form>
    </x-user-setting>
</x-main-layout>
