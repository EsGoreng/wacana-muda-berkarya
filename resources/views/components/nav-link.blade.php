@props(['active' => false, 'primary' => false])

@if ($primary)
    <a {{ $attributes }}
        class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 text-center me-3 md:me-0 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800">
        {{ $slot }}
    </a>
@else
    <a {{ $attributes }}
        class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
        aria-current="{{ request()->is('/') ? 'page' : false }}">
        {{ $slot }}
    </a>
@endif