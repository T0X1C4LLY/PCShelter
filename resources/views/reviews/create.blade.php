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
                <x-reviews.form-radio name="music">
                    It's all about music
                    &#10;How good it was for You?
                    &#10;Does it touch Your soul?
                    &#10;Do you feel like it is a concert?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="graphic">
                    Graphic
                    &#10;How beautiful this game is?
                    &#10;Remember that this score should be based on current graphic standards
                </x-reviews.form-radio>
                <x-reviews.form-radio name="atmosphere">
                    Atmosphere
                    &#10;How much do You feel the world You played in?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="difficulty">
                    Difficulty
                    &#10;How challenging this game is to beat?
                    &#10;How many times did you failed?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="storyline">
                    Storyline
                    &#10;How unpredictable the game is?
                    &#10;How many times it surprised You?
                    &#10;What about the plot twists?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="relaxation">
                    All about relax
                    &#10;Do You play this game just to feel stress-free?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="pleasure">
                    Pleasure
                    &#10;Does this game is satisfying?
                    &#10;Do You play it with pleasure?
                    &#10;Do You feel happy while playing it?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="child-friendly">
                    Child-friendly
                    &#10;Does this game is safe to play for the young ones?
                    &#10;Would You let Your child play it?
                    &#10;Does it do not contain blood/gore/NSFW content/etc. ?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="NSFW">
                    NSFW content
                    &#10;Does it contain nude/vulgar/offensive content ?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="gore">
                    All about gore, blood and violence
                    &#10;Forget about other game elements
                    &#10;How many times You kill/hurt others?
                    &#10;How much blood is shed?
                </x-reviews.form-radio>
                <x-reviews.form-radio name="unique">
                    Unique - how special this game is
                    &#10;More points = Fewer games like that one
                </x-reviews.form-radio>
                <x-reviews.form-radio name="general">
                    General score
                    &#10;remember that this score is not based on the others - it's about Your general opinion
                </x-reviews.form-radio>
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
