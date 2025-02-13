<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('images/Logo ITK.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>

<body class="h-screen" x-data="{ showPassword: false }">

    <!-- Toast -->

    {{-- @if ($errors->any())
        <div id="toast-danger"
            class="absolute end-2 top-2 mb-4 flex w-full max-w-xs items-center rounded-lg bg-white p-3 text-gray-500 shadow dark:bg-gray-800 dark:text-gray-400"
            role="alert">
            <div
                class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-red-200 text-red-500 dark:bg-red-800 dark:text-red-200">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">{{ $errors->first() }}</div>
            <button type="button"
                class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                data-dismiss-target="#toast-danger" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif --}}

    <x-toast></x-toast>

    <!-- End Toast -->

    <div class="flex min-h-screen items-center bg-blue-700 p-6">
        <div class="mx-auto h-1/3 max-w-4xl flex-1 overflow-hidden rounded-3xl bg-white shadow-xl">
            <div class="flex flex-col overflow-y-auto md:flex-row">

                <div class="flex w-full flex-col items-center justify-center p-8 md:w-1/2">
                    <img src="{{ asset('images/Logo ITK with Text.png') }}" alt="Logo ITK" class="mx-auto h-24">
                    <h1 class="mt-5 text-center text-[16px] font-semibold text-gray-700">
                        Sistem Informasi Manajemen Audit Mutu Internal
                    </h1>
                    <h2 class="mb-5 text-center text-[16px] font-semibold text-gray-700">
                        Institut Teknologi Kalimantan
                    </h2>

                    <form action="/auth" method="POST" class="flex w-full flex-col gap-y-2">
                        @csrf
                        <label class="text-sm" for="user">Email / NIP</label>
                        <div class="flex w-full items-center rounded-s-sm border border-gray-300 px-4 py-2 text-gray-400 duration-300 ease-in-out focus-within:border-indigo-800 focus-within:text-blue-800 focus:transition"
                            style="border-radius: 0.75rem">
                            <i class="icon fa fa-sm fa-envelope focus:text-indigo-800"></i>
                            <input autofocus
                                class="input-field ml-2 w-full rounded-sm border-0 py-0 text-sm transition duration-300 ease-in-out focus:shadow-outline-indigo"
                                type="text" name="user" id="user" required>
                        </div>
                        <label class="text-sm" for="password">Password</label>
                        <div class="flex w-full items-center rounded-s-sm border border-gray-300 px-4 py-2 text-gray-400 duration-300 ease-in-out focus-within:border-indigo-800 focus-within:text-blue-800 focus:transition"
                            style="border-radius: 0.75rem">
                            <i class="icon fa fa-sm fa-lock"></i>
                            <input
                                class="input-field mx-2 w-full rounded-sm border-0 py-0 text-sm transition duration-300 ease-in-out focus:shadow-outline-indigo"
                                :type="showPassword ? 'text' : 'password'" name="password" id="password" required>
                            <button type="button" @click="showPassword = !showPassword">
                                <i id="icon-toggle" class="fa fa-sm fa-eye"
                                    :style="showPassword ? 'color: #0D64AC' : 'color: #b5b5b5'"></i>
                            </button>
                        </div>

                        <!-- You should use a button here, as the anchor is only used for the example  -->
                        <button
                            class="block w-full rounded-lg border border-transparent bg-blue-700 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-blue-800 focus:outline-none focus:shadow-outline-indigo"
                            type="submit">
                            Login
                        </button>
                    </form>

                    <hr class="my-3 w-full border-gray-300" />

                    <p class="w-full">
                        <a class="flex justify-end text-sm font-normal text-blue-700 hover:underline"
                            href="/forgot-password">
                            Forgot your password?
                        </a>
                    </p>
                </div>
                <div class="hidden w-1/2 md:block">
                    <img aria-hidden="true" class="h-full w-full object-cover" src="{{ asset('images/login.jpg') }}"
                        alt="Office" />
                </div>

            </div>
        </div>
    </div>

</body>

</html>
