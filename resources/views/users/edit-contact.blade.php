<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('images/Logo ITK.png') }}">
</head>

<body>
    <div class="flex min-h-screen items-center p-6"
        style="background-image: url('/images/itk1.JPG'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="bg-tranparent mx-auto h-1/3 max-w-7xl flex-1 overflow-hidden rounded-3xl px-16 text-white">
            <div class="flex flex-col justify-end overflow-y-auto md:flex-row">
                <div class="bg-blue flex w-full flex-col items-center justify-center rounded-lg p-8 md:w-1/3"
                    style="background-color: rgb(151, 185, 215, 0.75);">
                    <div class="rounded-lg bg-white p-2">
                        <img src="{{ asset('images/Logo ITK_text.png') }}" alt="Logo ITK" class="mx-auto h-24">
                    </div>
                    <h1 class="mt-5 text-center text-[16px] font-semibold">
                        Sistem Informasi Manajemen Audit Mutu Internal
                    </h1>
                    <h2 class="mb-5 text-center text-[16px] font-semibold">
                        Institut Teknologi Kalimantan
                    </h2>

                    <form action="{{ route('contacts.update', ['id' => $user->id]) }}" method="POST"
                        class="flex w-full flex-col gap-y-2">
                        @csrf
                        @method('PUT')
                        <label for="contact" class="rounded bg-red-500 px-2 text-xs font-semibold text-white">
                            Wajib mengisi nomor WhatsApp untuk memulai
                        </label>
                        <!-- Contact User -->
                        <div>
                            <x-text-input id="contact"
                                class="mt-1 block w-full border-2 border-blue-600 text-gray-900" style="opacity: 0.85;"
                                type="tel" name="contact" :value="old('contact', $user->contact)" autocomplete="tel"
                                placeholder="{{ __('Masukkan Kontak Anda') }}" />
                            <x-input-error :messages="$errors->get('contact')" class="mt-2 font-bold" />
                        </div>

                        <!-- You should use a button here, as the anchor is only used for the example  -->
                        <button
                            class="mt-5 block w-full rounded-lg border border-transparent bg-blue-700 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-blue-800 focus:outline-none focus:shadow-outline-indigo"
                            type="submit">
                            Update
                        </button>
                    </form>

                    <hr class="my-5 w-full border-blue-800" />
                </div>
            </div>
        </div>
</body>

</html>
