<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <link rel="icon" href="{{ 'images/logo.png' }}">
    <title>{{ $title }}</title>
</head>

<body class="h-full bg-white dark:bg-primary-900">
    <div class="min-h-full">

        <x-navbar>{{ $title }}</x-navbar>

        <x-header :hidden="request()->is('/')">{{ $title }}</x-header>

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 bg-white dark:bg-primary-900">
                {{ $slot }}
            </div>
        </main>

        
        <x-footer></x-footer>
    </div>



</body>

</html>
