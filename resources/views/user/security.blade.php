<x-main-layout>
    <x-user-setting heading="Security">
        <x-dashboard.account-form property="name" :user="$user"/>
        <x-dashboard.account-form property="username" :user="$user"/>
        <x-dashboard.account-form property="email" :user="$user" type="email"/>

        <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1">
            <form method="POST" action="/user/change/password" class="text-sm w-full flex">
                @csrf
                <div class="w-5/12 space-y-2 my-auto">
                    <div class="flex">
                        <input id="password"
                               name="password"
                               type="password"
                               placeholder="New password"
                               class="w-full py-1 pl-2 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl truncate"
                        >
                    </div>
                    <div class="flex">
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               placeholder="Confirm password"
                               class="w-full py-1 pl-2 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl truncate"
                        >
                    </div>
                </div>
                <div class="w-4/12 my-auto text-left">
                    @error('password')
                        <span class="text-xs text-red-500 px-1">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="w-3/12 my-auto">
                        <button type="submit"
                                class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 rounded-full text-xs font-semibold text-white uppercase px-2 py-3 text-center w-full truncate"
                        >
                            Change Password
                        </button>
                </div>
            </form>
        </div>
        <div class="text-yellow-200 px-3 py-2 text-xl rounded-xl my-1 mt-4">
            <form method="POST" action="/user/change/delete" class="text-sm w-full flex">
                @csrf
                <div class="float-right w-full">
                    <div class="float-right w-3/12"
                        x-data="{ 'showWarning': false }"
                        @keydown.escape="showWarning = false"
                    >
                        <button type="button"
                                @click="showWarning = true"
                                class="transition-colors duration-300 bg-red-600 hover:bg-red-800 rounded-full text-xs font-semibold text-white uppercase py-3 px-2 text-center w-full truncate"
                        >
                            Delete Account
                        </button>

                        <div
                            class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
                            x-show="showWarning"
                        >
                            <div
                                class="max-w-3xl px-6 py-4 mx-auto text-left bg-gray-800 rounded-xl shadow-lg"
                                @click.away="showWarning = false"
                            >
                                <p class="text-red-500 max-w-none text-center text-3xl mb-3">
                                    Warning !
                                </p>

                                <div class="text-xl">
                                    Deleting account is irreversible, are You sure You want to continue?
                                </div>

                                <div class="mt-5">
                                    <button type="button" class="z-50 cursor-pointer text-xl text-yellow-500 float-left hover:text-yellow-700" @click="showWarning = false">
                                        No
                                    </button>

                                    <button type="submit" class="z-50 cursor-pointer text-xl text-red-600 float-right hover:text-red-800" @click="showWarning = false">
                                        Yes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-user-setting>
</x-main-layout>
