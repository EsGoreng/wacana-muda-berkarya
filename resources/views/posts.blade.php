<x-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="mx-auto max-w-screen-md sm:text-center">
        <h1
            class="mt-8 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            Cari Kata, Karya, dan Rasa</h1>
        <p class="mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
            Cari artikel dari Ruang Kata, proyek dari Jejak Karya, atau refleksi dari Jelajah Rasa kami di sini.
        </p>
        <form>
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('author'))
                <input type="hidden" name="author" value="{{ request('author') }}">
            @endif
            <div class="items-center mx-auto mb-4 md:mb-8 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                <div class="relative w-full">
                    <label for="search"
                        class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input
                        class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-primary-900 dark:border-primary-700 dark:placeholder-primary-300 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Search for Artikel" type="search" id="search" required="" name="search">
                </div>
                <div>
                    <button type="submit"
                        class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Search</button>
                </div>
            </div>
        </form>
    </div>

    <ul
        class="mb-8 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg lg:flex dark:bg-primary-900 dark:border-primary-700 dark:text-white">
        <li class="w-full border-b border-gray-200 lg:border-b-0 lg:border-r dark:border-gray-600">
            <div class="flex items-center p-3">
                <input id="socialpolitical-checkbox-list" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="socialpolitical-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Social
                    & Political Issues</label>
            </div>
        </li>
        <li class="w-full border-b border-gray-200 lg:border-b-0 lg:border-r dark:border-gray-600">
            <div class="flex items-center p-3">
                <input id="sciencetechnology-checkbox-list" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="sciencetechnology-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Science
                    & Technology</label>
            </div>
        </li>
        <li class="w-full border-b border-gray-200 lg:border-b-0 lg:border-r dark:border-gray-600">
            <div class="flex items-center p-3">
                <input id="healthwellnes-checkbox-list" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="healthwellnes-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Health
                    & Wellness</label>
            </div>
        </li>
        <li class="w-full border-b border-gray-200 lg:border-b-0 lg:border-r dark:border-gray-600">
            <div class="flex items-center p-3">
                <input id="lifestyle-checkbox-list" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="lifestyle-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Lifestyle</label>
            </div>
        </li>
        <li class="w-full border-b border-gray-200 lg:border-b-0 lg:border-r dark:border-gray-600">
            <div class="flex items-center p-3">
                <input id="entertainment-checkbox-list" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="entertainment-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Entertainment
                    & Culture</label>
            </div>
        </li>
        <li class="w-full border-b border-gray-200 lg:border-b-0 lg:border-r dark:border-gray-600">
            <div class="flex items-center p-3">
                <input id="businessfinance-checkbox-list" type="checkbox" value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="businessfinance-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Business
                    & Finance</label>
            </div>
        </li>
        <li class="w-full border-b border-gray-200 lg:border-b-0 lg:border-r dark:border-gray-600">
            <div class="flex items-center p-3">
                <input id="educationimprovement-checkbox-list" type="checkbox" value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="educationimprovement-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Education
                    & Self-Improvement</label>
            </div>
        </li>
        <li class="w-full border-gray-200 dark:border-gray-600 lg:border-b-0 lg:border-r">
            <div class="flex items-center p-3">
                <input id="hobbies-checkbox-list" type="checkbox" value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-primary-900 dark:focus:ring-offset-primary-900 focus:ring-2 dark:bg-primary-800 dark:border-primary-700">
                <label for="hobbies-checkbox-list"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hobbies</label>
            </div>
        </li>
    </ul>

    {{ $posts->links() }}

    <div class="lg:my-0 my-4 py-4 px-4 mx-auto max-w-screen-xl lg:py-8 lg:px-0">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($posts as $post)
                <article
                    class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-primary-800 dark:border-primary-700">
                    <div class="flex justify-between items-center mb-5 text-gray-500">
                        <a href="/posts?category={{ $post->category->slug }}">
                            <span
                                class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-{{ $post->category->color }}-100 dark:text-primary-800">
                                {{ $post->category->name }}
                            </span>
                        </a>

                        <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="/posts/{{ $post->slug }}" class="hover:underline">
                        <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $post->title }}
                    </a></h2>
                    </a>
                    <p class="mb-5 font-light text-gray-500 dark:text-gray-400">{{ Str::limit($post->body, 150) }}</p>
                    <div class="flex justify-between items-center">
                        <a href="/posts?author={{ $post->author->username }}">
                            <div class="flex items-center space-x-3">
                                <img class="w-7 h-7 rounded-full"
                                    src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png"
                                    alt="{{ $post->author->name }}" />
                                <span class="font-medium text-sm dark:text-white">
                                    {{ $post->author->name }}
                                </span>
                            </div>
                        </a>
                        <a href="/posts/{{ $post->slug }}"
                            class="inline-flex text-sm items-center font-medium text-primary-600 dark:text-white hover:underline">
                            Read more
                            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </article>

            @empty
                <div class="mb-5 font-light text-gray-500 dark:text-gray-400">
                    <p class="font-semibold text-xl my-4">Article not found</p>
                    <a href="/posts">&laquo; Back to all posts</a>
                </div>
            @endforelse

        </div>
    </div>

    {{ $posts->links() }}

</x-layout>
