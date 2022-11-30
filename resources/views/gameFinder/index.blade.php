<x-main-layout>
    <x-gameFinder.addSubControlScript/>
    <div class="text-center pt-2 pb-2">
        <div class="inline-flex bg-gray-800 rounded-xl px-3 py-2 w-1/4 text-right">
            <form class="w-full" method="POST" action="/game-finder" enctype="multipart/form-data">
                @csrf
                <x-gameFinder.formElement name="genre" :array="$genres"/>
                <x-gameFinder.formElement name="category" :array="$categories"/>
                <x-gameFinder.formElement name="type" :array="$reviewCategories" :isAllEnable=false />
                <div class="flex w-full">
                    <div class="flex flex-cols justify-between border border-gray-500 rounded-xl mb-3 w-11/12">
                        <div class="text-yellow-500 p-3 w-1/3">
                            <label for="date">Date:</label>
                        </div>
                        <div class="w-1/3 mx-2">
                            <input type="number"
                                   placeholder="From"
                                   min="1950"
                                   max="{{ date("Y") }}"
                                   step="1"
                                   ame="dateFrom"
                                   id="dateFrom"
                                   class="w-full text-yellow-500 my-2 bg-gray-500 rounded-xl py-1 px-3 appearance-none cursor-pointer"
                            >
                        </div>
                        <div class="w-1/3 mx-2">
                            <input type="number"
                                   placeholder="To"
                                   min="1950"
                                   max="{{ date("Y") }}"
                                   step="1"
                                   name="dateTo"
                                   id="dateTo"
                                   class="w-full text-yellow-500 my-2 bg-gray-500 rounded-xl py-1 px-3 appearance-none cursor-pointer"
                            >
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    @error('dateTo')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="text-center">
                    <x-form.button>
                        Find
                    </x-form.button>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>
