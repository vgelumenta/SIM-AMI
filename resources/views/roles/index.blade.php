<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('images/Logo ITK.png') }}">
</head>

<body>
    <div class="flex min-h-screen items-center bg-blue-700 p-6">
        <div class="mx-auto h-1/3 max-w-4xl flex-1 overflow-hidden rounded-3xl bg-white shadow-xl">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="hidden w-1/2 md:block">
                    <img aria-hidden="true" class="h-full w-full object-cover" src="{{ asset('images/itk2.JPG') }}"
                        alt="Office" />
                </div>
                <div class="flex w-full flex-col items-center justify-center p-8 md:w-1/2">
                    <img src="{{ asset('images/Logo ITK_text.png') }}" alt="Logo ITK" class="mx-auto h-24">
                    <h1 class="mt-5 text-center text-[16px] font-semibold text-gray-700">
                        Sistem Informasi Manajemen Audit Mutu Internal
                    </h1>
                    <h2 class="mb-5 text-center text-[16px] font-semibold text-gray-700">
                        Institut Teknologi Kalimantan
                    </h2>

                    <form action="/roles" method="POST" class="flex w-full flex-col gap-y-2">
                        @csrf
                        <label for="role" class="text-sm">Choose Role</label>
                        <!-- Select -->
                        <select name="role" id="role"
                            data-hs-select='{
                                "placeholder": "Choose Role...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-32 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                     }'
                            class="hidden">

                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <!-- End Select -->

                        <button
                            class="mt-5 block w-full rounded-lg border border-transparent bg-blue-700 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-blue-800 focus:outline-none focus:shadow-outline-indigo"
                            type="submit">
                            Login
                        </button>
                    </form>

                    <hr class="my-5 w-full border-gray-300" />
                </div>
            </div>
        </div>
</body>

</html>
