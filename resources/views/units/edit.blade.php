<x-app-layout>

    <div
        class="mb-4 flex items-center justify-between text-sm font-medium text-blue-800 dark:text-cool-gray-50 md:text-lg">
        <ol class="flex items-center">
            <li>
                <a href="/units" class="mx-1 hover:underline">
                    Units
                </a>
            </li>
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
                            {{ $unit->code }}
                            <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="dropdown" class="z-10 hidden divide-y divide-gray-100 rounded-md bg-white shadow-md">
                            <ul class="text-sm font-semibold text-gray-900" aria-labelledby="dropdownDefault">
                                @foreach ($units as $u)
                                    <li>
                                        <a href="{{ route('units.edit', ['unit' => $u->id]) }}"
                                            class="block rounded-md px-4 py-2 hover:bg-gray-300">
                                            {{ $u->code }}
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
        </ol>
    </div>

    <div
        class="overflow-x-auto rounded-sm bg-white p-6 shadow-lg scrollbar-thin dark:bg-gray-900 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800 md:h-[545px]">
        <header class="text-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Ubah ' . $unit->name) }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Ubah nama dan singkatan Unit.') }}
            </p>
        </header>
        <form action="/units/{{ $unit->id }}" method="POST" class="mx-auto my-4 max-w-xl">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 w-full" :value="old('name', $unit->name)"
                    required autofocus autocomplete="name" placeholder="{{ __('Nama Unit') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <!-- Code -->
            <div class="mt-4">
                <x-input-label for="code" :value="__('Code')" />
                <x-text-input id="code" name="code" type="text" class="mt-1 w-full" :value="old('code', $unit->code)"
                    required placeholder="{{ __('Kode/Singkatan Unit') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('code')" />
            </div>
            <!-- Faculty -->
            <div id="faculty" class="mt-4 hidden">
                <x-input-label for="faculty" :value="__('Faculty')" />
                <select name="faculty" id="faculty"
                    class="mt-1 w-full rounded-md text-sm shadow-sm focus:ring-blue-800 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                    <option value="" disabled {{ old('faculty') ? '' : 'selected' }} hidden>
                        Choose Faculty</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ old('faculty', $unit->faculty_id) == $faculty->id ? 'selected' : '' }}>
                            {{ $faculty->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('faculty')" />
            </div>
            <!-- Button -->
            <div class="mt-8 space-x-2 text-right">
                <a href="/units"
                    class="inline-flex rounded-md bg-gray-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700">
                    {{ __('Batal') }}
                </a>
                <x-primary-button>
                    {{ __('Ubah') }}
                </x-primary-button>

            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            const facultyDiv = document.getElementById('faculty');

            // Fungsi untuk mengecek apakah nilai `code` dimulai dengan angka
            function checkFacultyVisibility() {
                if (codeInput.value && codeInput.value.charAt(0).match(/\d/)) {
                    facultyDiv.classList.remove('hidden');
                } else {
                    facultyDiv.classList.add('hidden');
                }
            }

            // Panggil fungsi saat halaman pertama kali dimuat
            checkFacultyVisibility();

            // Panggil fungsi setiap kali input `code` berubah
            codeInput.addEventListener('input', function() {
                checkFacultyVisibility();
            });
        });
    </script>
</x-app-layout>
