<x-main-layout>
    <div class="text-yellow-300 max-w-screen-xl mx-auto border-2 rounded-xl bg-gray-800">
        <div class="px-3 py-2 text-sm">
            <div class="text-center text-4xl flex flex-col pb-2">
                <h1> {{ $name }} </h1>
            </div>
        </div>
        <form method="POST" action="/add-review?name={{ $name }}" enctype="multipart/form-data" class="text-center pb-2">
            @csrf
            <div class=" grid grid-cols-2">
                <x-reviews.form-radio name="music">Only about music</x-reviews.form-radio>
                <x-reviews.form-radio name="graphic"/>
                <x-reviews.form-radio name="atmosphere"/>
                <x-reviews.form-radio name="difficulty"/>
                <x-reviews.form-radio name="storyline"/>
                <x-reviews.form-radio name="relaxation"/>
                <x-reviews.form-radio name="pleasure"/>
                <x-reviews.form-radio name="child-friendly"/>
                <x-reviews.form-radio name="NSFW"/>
                <x-reviews.form-radio name="gore"/>
                <x-reviews.form-radio name="unique"/>
                <x-reviews.form-radio name="general"/>
            </div>
            <input id="game_id"
                   name="game_id"
                   type="hidden"
                   value="{{ $id }}"
            >
            <x-form.button>Add Review</x-form.button>
        </form>
    </div>
</x-main-layout>
