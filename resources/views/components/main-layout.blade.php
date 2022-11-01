<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'PCShelter') }}</title>

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="/images/favicon1.png">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <style>
            html {
                scroll-behavior: smooth;
            }

            .clamp {
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .clamp.one-line {
                -webkit-line-clamp: 1;
            }
        </style>
    </head>
    <body style="font-family: Open Sans, sans-serif; background-color: #1a202c" >
    <section class="px-6 py-8 bg-slate-700">
        <nav class="md:flex md:justify-between md:items-center">
            <div x-data="{ showLogo: false }" @click.away="showLogo = false" class="relative">
                <div @click="showLogo = ! showLogo" class="cursor-pointer">
                    <x-breeze.application-logo/>
                </div>
                <div x-show="showLogo"
                     class="py-2 absolute bg-gray-100 w-full mt-2 rounded-xl z-50 overflow-auto max-h-52"
                     style="display: none"
                >
                    <x-dropdown-item href="/"
                                     :active="request()->routeIs('home') && is_null(request()->getQueryString())"
                    >
                        Posts
                    </x-dropdown-item>
                    <x-dropdown-item href="/games"
                                     :active="request()->routeIs('games') && is_null(request()->getQueryString())"
                    >
                        Games
                    </x-dropdown-item>
                    <x-dropdown-item href="/game-finder"
                                     :active="request()->routeIs('game-finder') && is_null(request()->getQueryString())"
                    >
                        Game Finder
                    </x-dropdown-item>
                </div>
            </div>
            <div class="mt-8 md:mt-0 flex items-center text-white">
                @auth
                    @can('login_to_steam')
                        <div>
                            <x-steam-login-button/>
                        </div>
                    @endcan
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button class="text-xs font-bold uppercase">
                                Welcome, {{ auth()->user()->name }}
                            </button>
                        </x-slot>

                        @can('enter_dashboard')
                            <x-dropdown-item href="/admin/posts" :active="request()->is('admin/posts')">Dashboard</x-dropdown-item>
                        @endcan
                        @can('create_post')
                            <x-dropdown-item href="/user/posts/create" :active="request()->is('admin/posts/create')">New Post</x-dropdown-item>
                        @endcan
                        <x-dropdown-item href="/user/account" :active="request()->is('user/account')">My Account</x-dropdown-item>
                        <x-dropdown-item href="#" x-data="{}" @click.prevent="document.querySelector('#logout-form').submit()">Log Out</x-dropdown-item>
                        <form id="logout-form" method="POST" action="/logout" class="hidden">
                            @csrf
                        </form>
                    </x-dropdown>

                @else
                    <a href="/register" class="text-xs font-bold uppercase">Register</a>
                    <a href="/login" class="ml-6 text-xs font-bold uppercase">Log In</a>
                @endauth
                @if(request()->is('/'))
                    @cannot('unsubscribe')
                        <a href="#newsletter"
                           class="bg-yellow-500 ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-5"
                        >
                            Subscribe for Updates
                        </a>
                    @endcannot
                @endif
            </div>
        </nav>
        {{ $slot }}
        @if(request()->is('/'))
            <footer id="newsletter"
                    class="bg-gray-800 border border-black border-opacity-5 rounded-xl text-center py-16 px-10 mt-16"
            >
                {{--        <img src="/images/lary-newsletter-icon.svg" alt="" class="mx-auto -mb-6" style="width: 145px;">--}}
                <h5 class="text-3xl text-white">
                    Stay in touch with newsletter the latest posts
                </h5>
                <p class="text-sm mt-3 text-white">
                    Promise to keep the inbox clean. No bugs.
                </p>

                @cannot('unsubscribe')
                    <div class="mt-10">
                        <div class="relative inline-block mx-auto lg:bg-gray-200 rounded-full">

                            <form method="POST" action="/subscribe" class="lg:flex text-sm">
                                @csrf
                                <div class="lg:py-3 lg:px-5 flex items-center">
                                    <label for="email" class="hidden lg:inline-block">
                                        <img src="/images/mailbox-icon.svg" alt="mailbox letter">
                                    </label>

                                    <div>
                                        <input id="email"
                                               name="email"
                                               type="text"
                                               placeholder="Your email address"
                                               class="lg:bg-transparent py-2 lg:py-0 pl-4 focus-within:outline-none text-yellow-600"
                                               value="{{ auth()->user()->email ?? ''}}"
                                               {{ auth()->user() ? 'readonly="true"' : '' }}"
                                        >
                                        @error('email')
                                            <span class="text-xs text-red-500">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit"
                                        class="transition-colors duration-300 bg-yellow-500 hover:bg-yellow-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8"
                                >
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="text-sm mt-3 text-white">
                        You are already a subscriber
                    </p>
                @endcannot
            </footer>
        @endif
    </section>
{{--        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">--}}
{{--            {{ $slot }}--}}
{{--        </div>--}}
    <x-flash/>
    </body>
</html>
