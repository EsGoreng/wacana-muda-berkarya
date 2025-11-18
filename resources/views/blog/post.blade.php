@extends('layouts.app')

@section('title', $title)

@section('content')

<main class="pt-8 pb-16 lg:pt-16 lg:pb-24">
    <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
        <article
            class="mx-auto w-full max-w-4xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <header class="mb-4 lg:mb-6 not-format">

                <a href="javascript:history.back()"
                    class="inline-flex items-center text-m font-medium text-gray-900 dark:text-white hover:underline">
                    <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>

                <address class="flex items-center my-6 not-italic">
                    <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                        <img class="mr-4 w-16 h-16 rounded-full"
                            src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                            alt="{{ $post->author->name }}">
                        <div>
                            <a href="/blogs?author={{ $post->author->username }}" rel="author"
                                class="text-xl font-bold text-gray-900 dark:text-white">{{ $post->author->name }}</a>
                            <p class="text-base text-gray-500 dark:text-gray-400 mb-2">
                                {{ $post->created_at->diffForHumans() }}</p>
                            <a href="/blogs?category={{ $post->category->slug }}">
                                <span
                                    class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-{{ $post->category->color }}-100 dark:text-primary-800">
                                    {{ $post->category->name }}
                                </span>
                            </a>

                        </div>
                    </div>
                </address>
                <h1
                    class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                    {{ $post->title }}</h1>
            </header>
            <p class="text-xl text-gray-900 dark:text-white">{{ $post->body }}</p>
        </article>
    </div>
</main>

@endsection