<!DOCTYPE html>
<html lang="id" x-data="data()" :class="{ 'dark': dark }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/echo.js'])

    <style>
        .slide {
            margin-left: -240px;
        }

        .pane.active {
            flex-grow: 10;
            max-width: 100%;
        }

        .pane.active .background {
            transform: scale(1.25, 1.25);
        }

        .pane.active .label {
            transform: translateX(0.5rem);
        }

        .pane.active .content>* {
            opacity: 1;
            transform: translateX(0);
        }

        .pane.active .shadow {
            opacity: 0.75;
            transform: translateY(0);
        }

        .pane.active .content>.desc {
            opacity: 1;
            transform: translateX(0);
        }
    </style>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/Logo ITK.png') }}">
    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.min.css">
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>

<body class="flex h-screen bg-cool-gray-50 dark:bg-gray-800">

    <!-- Toast -->
    <x-toast></x-toast>
    <!-- End Toast -->

    @include('layouts.navbar')

    <div class="flex w-full flex-1 flex-col overflow-hidden">

        @include('layouts.header')

        <main
            class="h-full w-full overflow-y-auto overflow-x-hidden px-6 scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">

            {{ $slot }}

        </main>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("toggle-sidebar").addEventListener("click", function() {
                document.querySelector("aside").classList.toggle("slide");
            });
        });
    </script>
    <script src="https://kit.fontawesome.com/478979d709.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/focus-trap.js') }}"></script>

</body>

</html>
