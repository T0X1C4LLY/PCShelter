<x-main-layout>
    <div>
        <div class="text-center pt-2 pb-2">
            <div class="inline-flex bg-gray-800 rounded-xl px-3 py-2">
                <form class="w-full" method="POST" action="/game-finder">
                    @csrf
                    <div class="flex flex-cols justify-between border border-gray-500 rounded-xl mb-3">
                        <div class="text-yellow-500 p-3 w-1/2">
                            <label for="genre">Genres:</label>
                        </div>
                        <div class="w-1/2 mx-2">
                            <select name="genre" id="genre" class="w-full text-yellow-500 my-2 bg-gray-500 rounded-xl py-1 px-3 appearance-none min-w-max cursor-pointer">
                                <option value="all">All</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre['name'] }}">{{ ucfirst($genre['name']) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-cols justify-between border border-gray-500 rounded-xl mb-3">
                        <div class="text-yellow-500 p-3 w-1/2">
                            <label for="category">Categories:</label>
                        </div>
                        <div class="w-1/2 mx-2">
                            <select name="category" id="category" class="text-yellow-500 m-2 bg-gray-500 rounded-xl py-1 px-3 appearance-none min-w-max cursor-pointer">
                                <option value="all">All</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['name'] }}">{{ ucfirst($category['name']) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <x-form.button>Find</x-form.button>
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
