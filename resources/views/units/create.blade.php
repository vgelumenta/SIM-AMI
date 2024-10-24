<x-app-layout>

    <div
        class="mb-4 flex items-center justify-between text-sm font-medium text-blue-800 dark:text-cool-gray-50 md:text-lg">
        <ol class="flex items-center">
            <li>
                <a href="/units" class="mx-1 hover:underline">
                    Units
                </a>
            </li>
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
        </ol>
    </div>

    <div
        class="overflow-x-auto rounded-sm bg-white p-6 shadow-lg scrollbar-thin dark:bg-gray-900 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800 md:h-[545px]">
        <header class="text-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Daftarkan Unit Baru') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Masukkan nama dan singkatan Unit.') }}
            </p>
        </header>
        <form action="/units" method="POST" class="mx-auto my-4 max-w-xl">
            @csrf
            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 w-full" :value="old('name')"
                    required autofocus autocomplete="name" placeholder="{{ __('Nama Unit') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <!-- Code -->
            <div class="mt-4">
                <x-input-label for="code" :value="__('Code')" />
                <x-text-input id="code" name="code" type="text" class="mt-1 w-full" :value="old('code')"
                    required placeholder="{{ __('Kode/Singkatan Unit') }}" />
                <x-input-error class="mt-2" :messages="$errors->get('code')" />
            </div>
            <!-- Faculty -->
            <div id="faculty" class="mt-4 hidden">
                <x-input-label for="faculty" :value="__('Faculty')" />
                <select name="faculty"
                    class="mt-1 w-full rounded-md text-sm shadow-sm focus:ring-blue-800 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                    <option value="" disabled {{ old('faculty') ? '' : 'selected' }} hidden>
                        Choose Faculty</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ old('faculty') == $faculty->id ? 'selected' : '' }}>
                            {{ $faculty->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('faculty')" />
            </div>
            <!-- Button -->
            <div class="mt-8 space-x-2 text-right">
                <a href="/faculties"
                    class="inline-flex rounded-md bg-gray-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700">
                    {{ __('Batal') }}
                </a>
                <x-primary-button>
                    {{ __('Daftar') }}
                </x-primary-button>

            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            const facultyDiv = document.getElementById('faculty');

            codeInput.addEventListener('input', function() {
                if (this.value.charAt(0).match(/\d/)) { // Cek apakah karakter pertama adalah angka
                    facultyDiv.classList.remove('hidden');
                } else {
                    facultyDiv.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
