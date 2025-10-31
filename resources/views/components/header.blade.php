@props(['hidden' => false])

<header class="relative bg-white shadow-sm dark:bg-primary-600 {{ $hidden ? 'hidden' : '' }}">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-primary-50">{{ $slot }}</h1>
    </div>
</header>
