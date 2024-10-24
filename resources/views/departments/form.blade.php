<x-app-layout>

    <div
        class="mb-4 flex items-center justify-between text-sm font-medium text-blue-800 dark:text-cool-gray-50 md:text-lg">
        <ol class="flex items-center">
            <li>
                <a href="/faculties" class="mx-1 hover:underline">
                    Faculties
                </a>
            </li>
            @if (isset($faculty))
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="mx-1 h-3 w-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <div>
                            <button id="dropdownDefault" data-dropdown-toggle="dropdown"
                                class="mx-1 inline-flex items-center rounded-md border-2 border-blue-800 px-2 py-1 text-sm font-medium hover:bg-blue-800 hover:text-cool-gray-50 hover:shadow-outline-blue focus:shadow-outline-blue dark:border-cool-gray-50">
                                {{ $faculty->code }}
                                <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="dropdown"
                                class="z-10 hidden divide-y divide-gray-100 rounded-md bg-white shadow-md">
                                <ul class="text-sm font-semibold text-gray-900" aria-labelledby="dropdownDefault">
                                    @foreach ($faculties as $faculty)
                                        <li>
                                            <a href="{{ route('faculties.edit', ['faculty' => $faculty->id]) }}"
                                                class="block rounded-md px-4 py-2 hover:bg-gray-300">
                                                {{ $faculty->code }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </li>
                <li>
                    <svg class="mx-1 h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li>
                    <a class="mx-1">
                        Edit
                    </a>
                </li>
            @else
                <li>
                    <svg class="mx-1 h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li>
                    <a class="mx-1">
                        Create
                    </a>
                </li>
            @endif
        </ol>
    </div>

    <div
        class="overflow-x-auto rounded-sm bg-white p-6 shadow-lg scrollbar-thin dark:bg-gray-900 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800 md:h-[545px]">
        <header class="text-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ $header }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Masukkan nama dan singkatan jurusan.') }}
            </p>
        </header>
        <form action="{{ $route }}" method="POST" class="mx-auto my-4 max-w-xl">
            @csrf
            @if (isset($faculty))
                @method('PUT')
            @endif
            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $faculty->name ?? '')"
                    required autofocus autocomplete="name" placeholder="{{ __('Nama Jurusan') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <!-- Code -->
            <div class="mt-4">
                <x-input-label for="code" :value="__('Code')" />
                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $faculty->code ?? '')"
                    required placeholder="{{ __('Singkatan Jurusan') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('code')" />
            </div>
            <div class="mt-8 space-x-2 text-right">
                <a href="/faculties"
                    class="inline-flex rounded-md bg-gray-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700">
                    {{ __('Batal') }}
                </a>
                <x-primary-button>
                    {{ $submit }}
                </x-primary-button>

            </div>
        </form>
    </div>
</x-app-layout>
