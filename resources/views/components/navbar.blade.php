<nav class="bg-white border-gray-200 dark:bg-primary-800 sticky top-0 z-[60]">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between p-4">

        <!-- Logo -->
        <div class="flex-shrink-0">
            <a href="/" class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
                <span class="self-center lg:text-2xl text-xl font-semibold whitespace-nowrap dark:text-white">
                    Wacana Muda Berkarya
                </span>
            </a>
        </div>

        <!-- Desktop Menu (tidak diubah) -->
        <div class="hidden lg:flex justify-center flex-1">
            <ul class="flex space-x-8 font-medium">
                <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                <x-nav-link href="/blogs" :active="request()->is('blogs')">Blog</x-nav-link>
                <x-nav-link href="/thread" :active="request()->is('thread')">Thread</x-nav-link>
                <x-nav-link href="/event" :active="request()->is('event')">Event</x-nav-link>
            </ul>
        </div>

        <!-- Desktop Auth (tidak diubah) -->
        <div class="hidden lg:flex items-center space-x-6">
            @auth
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->is('dashboard/posts')">Dashboard</x-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-nav-link>
                </form>
            @endauth

            @guest
                <ul class="flex space-x-8 font-medium">
                    <x-nav-link href="{{ route('login') }}" :active="request()->is('login')">Login</x-nav-link>
                    <x-nav-link href="{{ route('register') }}" :active="request()->is('register')">Register</x-nav-link>
                </ul>
            @endguest
        </div>

        <!-- Mobile Toggle Button -->
        <div class="lg:hidden">
            <button data-collapse-toggle="navbar-mobile" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                aria-controls="navbar-mobile" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Menu Only (Flowbite-style Collapse) -->
    <div class="hidden lg:hidden w-full px-4 pb-8" id="navbar-mobile">
        <ul class="flex flex-col p-4 mt-2 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 space-y-2 font-medium">

            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link href="/blogs" :active="request()->is('blogs')">Blog</x-nav-link>
            <x-nav-link href="/thread" :active="request()->is('thread')">Thread</x-nav-link>
            <x-nav-link href="/event" :active="request()->is('event')">Event</x-nav-link>

            @auth
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->is('dashboard/posts')">
                    Dashboard
                </x-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-nav-link>
                </form>
            @endauth

            @guest
                <x-nav-link href="{{ route('login') }}" :active="request()->is('login')">Login</x-nav-link>
                <x-nav-link href="{{ route('register') }}" :active="request()->is('register')">Register</x-nav-link>
            @endguest

        </ul>
    </div>
</nav>
