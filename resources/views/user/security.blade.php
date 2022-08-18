<x-main-layout>
    <x-user-setting heading="Manage Your account">
        <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1">
            <form method="POST" action="/user/change/name" class="text-sm w-full flex">
                @csrf
                <div class="w-3/4 flex">
                    <input id="name"
                           name="name"
                           type="text"
                           placeholder="{{ auth()->user()->name ?? ''}}"
                           class="py-2 lg:py-0 pl-4 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl"
                    >
                    @error('name')
                    <span class="text-xs text-red-500 py-3 px-1">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="w-1/4">
                    <div class="w-full">
                        <button type="submit"
                                class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 rounded-full text-xs font-semibold text-white uppercase py-3 px-8 text-center w-full"
                        >
                            Change Name
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1">
            <form method="POST" action="/user/change/username" class="text-sm w-full flex">
                @csrf
                <div class="w-3/4 flex">
                        <input id="username"
                               name="username"
                               type="text"
                               placeholder="{{ auth()->user()->username ?? ''}}"
                               class="py-2 lg:py-0 pl-4 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl"
                        >
                        @error('username')
                        <span class="text-xs text-red-500 py-3 px-1">
                            {{ $message }}
                        </span>
                        @enderror
                </div>
                <div class="w-1/4">
                    <div class="w-full">
                        <button type="submit"
                                class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 rounded-full text-xs font-semibold text-white uppercase py-3 px-8 text-center w-full"
                        >
                            Change Username
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1">
            <form method="POST" action="/user/change/email" class="text-sm w-full flex">
                @csrf
                <div class="w-3/4 flex">
                    <input id="email"
                           name="email"
                           type="email"
                           placeholder="{{ auth()->user()->email ?? ''}}"
                           class="py-2 lg:py-0 pl-4 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl"
                    >
                    @error('email')
                    <span class="text-xs text-red-500 py-3 px-1">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="w-1/4">
                    <div class="w-full">
                        <button type="submit"
                                class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 rounded-full text-xs font-semibold text-white uppercase py-3 px-8 text-center w-full"
                        >
                            Change Email
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="text-yellow-200 px-3 py-2 text-xl border border-white rounded-xl my-1">
            <form method="POST" action="/user/change/password" class="text-sm w-full flex">
                @csrf
                <div class="w-3/4 space-y-2">
                    <div class="flex">
                        <input id="password"
                               name="password"
                               type="password"
                               placeholder="New password"
                               class="py-2 lg:py-1 pl-4 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl"
                        >
                        @error('password')
                        <span class="text-xs text-red-500 py-3 px-1">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="flex">
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               placeholder="Repeat password"
                               class="py-2 lg:py-1 pl-4 focus-within:outline-none text-yellow-600 bg-gray-600 rounded-full text-2xl"
                        >
                        @error('password_confirmation')
                        <span class="text-xs text-red-500 py-3 px-1">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="w-1/4 my-auto">
                    <div class="w-full">
                        <button type="submit"
                                class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 rounded-full text-xs font-semibold text-white uppercase py-3 px-8 text-center w-full"
                        >
                            Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="text-yellow-200 px-3 py-2 text-xl rounded-xl my-1 mt-4">
            <form method="POST" action="/" class="text-sm w-full flex">
                @csrf
                <div class="float-right w-full">
                    <div class="float-right">
                        <button type="submit"
                                class="transition-colors duration-300 bg-red-600 hover:bg-red-800 rounded-full text-xs font-semibold text-white uppercase py-3 px-8 text-center"
                        >
                            Delete Account
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-user-setting>
</x-main-layout>
