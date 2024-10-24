<!DOCTYPE html>
<html lang="id" x-data="data()" :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>404 - SIM AMI ITK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/Logo ITK.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>

<body class="flex h-screen items-start justify-center bg-cool-gray-50 p-20 dark:bg-gray-800">
    <main class="flex flex-col items-center justify-start gap-4">
        <svg class="h-12 w-12 text-red-400" fill="currentColor" fill-rule="evenodd" viewBox="0 0 20 20">
            <path
                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z">
            </path>
        </svg>
        <h1 class="text-6xl font-semibold text-gray-700 dark:text-gray-200">
            503
        </h1>
        <p class="text-sm text-gray-700 dark:text-gray-300 md:text-lg">
            We're currently under maintenance.
            <a href="/" class="font-semibold text-purple-600 hover:underline dark:text-purple-600">
                Please check back soon.
            </a>
        </p>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
