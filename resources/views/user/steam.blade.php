<x-main-layout>
    <x-user-setting heading="Steam">
        <div class="w-full text-center items-center">
            @can('login_to_steam')
                <div class="mb-2 text-yellow-500">
                    Login to Your Steam account to be able to use all functionalities of PCShelter
                </div>
                <x-steam-login-button/>
            @else
                <div class="mb-2 text-yellow-500">
                    Delete all Your Steam's data
                </div>
                <form method="POST" action="/steam">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="transition-colors duration-300 bg-red-600 hover:bg-red-800 rounded-full text-xs font-semibold text-white uppercase py-3 px-3 text-center truncate"
                    >
                        Delete Steam data
                    </button>
                </form>
            @endcannot
        </div>
    </x-user-setting>
</x-main-layout>
