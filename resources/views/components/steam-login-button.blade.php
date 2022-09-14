@cannot('delete_steam_data')
    <form method="GET" action="/auth/steam" class="lg:flex text-sm">
        @csrf
        <button>
            <img
                src="https://community.cloudflare.steamstatic.com/public/images/signinthroughsteam/sits_02.png"
                class="w-28 h-16 mr-2"
            >
        </button>
    </form>
@endcannot
