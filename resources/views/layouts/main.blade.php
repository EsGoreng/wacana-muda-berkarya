<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <link rel="icon" href="{{ 'images/logo.png' }}">
    <title>{{ $title }}</title>
</head>

<body class="h-full bg-white dark:bg-primary-900">
    <div class="min-h-full">

        <x-navbar>{{ $title }}</x-navbar>

        <x-header :hidden="request()->is('/')">{{ $title }}</x-header>

        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">

        </aside>

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 bg-white dark:bg-primary-900">
                {{ $slot }}
            </div>
        </main>


        <x-footer></x-footer>
    </div>


    <aside id="mobile-menu-drawer"
        class="fixed top-0 left-0 z-50 w-64 h-screen pt-20 p-4 overflow-y-auto transition-transform -translate-x-full bg-gray-50 dark:bg-primary-800"
        tabindex="-1" aria-labelledby="mobile-menu-drawer-label">

        <h5 id="mobile-menu-drawer-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">
            Menu</h5>

        <div class="py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li><x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link></li>
                <li><x-nav-link href="/posts" :active="request()->is('posts')">Blog</x-nav-link></li>
                <li><x-nav-link href="/about" :active="request()->is('about')">Thread</x-nav-link></li>
                <li><x-nav-link href="/about" :active="request()->is('about')">Event</x-nav-link></li>
                <hr class="my-2 border-gray-200 dark:border-gray-600">
                @auth
                    <li><x-nav-link href="{{ route('dashboard') }}" :active="request()->is('dashboard')">Dashboard</x-nav-link></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-nav-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-nav-link>
                        </form>
                    </li>
                @endauth
                @guest
                    <li><x-nav-link href="{{ route('login') }}" :active="request()->is('login')">Login</x-nav-link></li>
                    <li><x-nav-link href="{{ route('register') }}" :active="request()->is('register')">Register</x-nav-link></li>
                @endguest
            </ul>
        </div>
    </aside>

</body>

</html>
