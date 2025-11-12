<nav class="bg-white border-gray-200 dark:bg-primary-800 sticky top-0 z-[60]">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between p-4">

        <div class="flex-shrink-0">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
                <span class="self-center lg:text-2xl text-xl font-semibold whitespace-nowrap dark:text-white">
                    Wacana Muda Berkarya
                </span>
            </a>
        </div>

        <div class="hidden lg:flex justify-center flex-1">
            <ul class="flex space-x-8 font-medium">
                <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                <x-nav-link href="/posts" :active="request()->is('posts')">Blog</x-nav-link>
                <x-nav-link href="/about" :active="request()->is('about')">Thread</x-nav-link>
                <x-nav-link href="/about" :active="request()->is('about')">Event</x-nav-link>
            </ul>
        </div>

        <div class="hidden lg:flex items-center space-x-6">
            @auth
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->is('dashboard')">Dashboard</x-nav-link>
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
        </div>

        <div class="lg:hidden">
            <button data-drawer-target="mobile-menu-drawer" data-drawer-toggle="mobile-menu-drawer" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none dark:text-gray-300 dark:hover:bg-gray-700"
                aria-controls="mobile-menu-drawer">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
</nav>