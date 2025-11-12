<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <script>
                        function previewImage() {
                            const image = document.querySelector('#image');
                            const imgPreview = document.querySelector('.img-preview');

                            imgPreview.style.display = 'block';

                            const oFReader = new FileReader();
                            oFReader.readAsDataURL(image.files[0]);

                            oFReader.onload = function(oFREvent) {
                                imgPreview.src = oFREvent.target.result;
                            }
                        }
                    </script>

                    <a href="{{ route('dashboard.posts.index') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-4 inline-block">
                        &laquo; Back to My Posts
                    </a>

                    <form method="POST" action="{{ route('dashboard.posts.update', $post) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id"
                                class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                            <select id="category_id" name="category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Post
                                Image</label>

                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}"
                                    class="img-preview w-full max-w-sm h-auto object-cover rounded-lg mb-2 border">

                                <div class="flex items-center mb-2">
                                    <input id="delete_image" name="delete_image" type="checkbox" value="1" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="delete_image" class="ml-2 text-sm font-medium text-red-600 dark:text-red-500">
                                        Hapus gambar ini saat update
                                    </label>
                                </div>
                            @else
                                <img class="img-preview w-full max-w-sm h-auto object-cover rounded-lg mb-2 border"
                                    style="display: none;">
                            @endif

                            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage()">

                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="body" class="block mb-2 text-sm font-medium text-gray-900">Body</label>

                            <input type="hidden" id="body" name="body" value="{{ old('body', $post->body) }}">

                            <div id="editor" style="height: 300px;">
                                {!! old('body', $post->body) !!}
                            </div>

                            @error('body')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Update Post
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-layout>
