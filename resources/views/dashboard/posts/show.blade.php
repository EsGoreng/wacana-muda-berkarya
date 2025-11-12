<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('dashboard.posts.index') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-4 inline-block">
                        &laquo; Back to My Posts
                    </a>

                    <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>

                    @if ($post->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                class="w-full max-w-2xl h-auto object-cover rounded-lg mx-auto">
                        </div>
                    @endif

                    <div class="text-base text-gray-500 mb-4">
                        In <a href="/posts?category={{ $post->category->slug }}"
                            class="text-blue-500 hover:underline">{{ $post->category->name }}</a>
                    </div>

                    <article class="prose max-w-none">
                        {!! $post->body !!}
                    </article>
                </div>
            </div>
        </div>
    </div>
</x-layout>
