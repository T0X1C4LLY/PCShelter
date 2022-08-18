<x-main-layout>
    <x-user-setting heading="Manage Your account">
        <div class="flex-col items-center w-full text-center truncate">
            <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 flex">
                <div class="w-1/2 text-right pr-1">
                    Username:
                </div>
                <div class="w-1/2 text-yellow-400 text-left pl-1 truncate">
                    {{ $user[0]->username }}
                </div>
            </div>
            <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 flex">
                <div class="w-1/2 text-right pr-1">
                    Email:
                </div>
                <div class="w-1/2 text-yellow-400 text-left pl-1 truncate">
                    {{ $user[0]->email }}
                </div>
            </div>
            <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 flex">
                <div class="w-1/2 text-right pr-1">
                    Email verified at:
                </div>
                <div class="w-1/2 text-yellow-400 text-left pl-1 truncate">
                    {{ $user[0]->email_verified_at }}
                </div>
            </div>
            <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 flex">
                <div class="w-1/2 text-right pr-1">
                    Account created at:
                </div>
                <div class="w-1/2 text-yellow-400 text-left pl-1 truncate">
                    {{ $user[0]->created_at }}
                </div>
            </div>
            <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 flex">
                <div class="w-1/2 text-right pr-1">
                    Posts created:
                </div>
                <div class="w-1/2 text-yellow-400 text-left pl-1 truncate">
                    {{ count($posts) }}
                </div>
            </div>
            <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1 flex">
                <div class="w-1/2 text-right pr-1">
                    Comments written:
                </div>
                <div class="w-1/2 text-yellow-400 text-left pl-1 truncate">
                    {{ count($comments) }}
                </div>
            </div>
        </div>
    </x-user-setting>
</x-main-layout>
