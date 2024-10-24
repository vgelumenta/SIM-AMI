<x-app-layout>
    <div
        class="mb-4 flex items-center justify-between text-sm font-medium text-blue-800 dark:text-cool-gray-50 md:text-lg">
        <ol class="flex items-center">
            <li>
                <a href="/users" class="mx-1 hover:underline">
                    Users
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
        class="overflow-x-auto rounded-md bg-white p-6 shadow-lg scrollbar-thin dark:bg-gray-900 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800 md:h-[545px]">

        <header class="text-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Daftarkan Pengguna Baru') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Masukkan pencarian untuk mendaftarkan pengguna baru.') }}
            </p>
        </header>

        <!-- Search input -->
        <div class="relative mx-12 mt-3 flex flex-1 justify-center lg:mx-32">
            <div class="relative mx-6 w-60 max-w-lg focus-within:text-blue-800 dark:focus-within:text-blue-500">
                <div class="absolute inset-y-0 flex items-center px-4 text-gray-800 dark:text-cool-gray-50">
                    <i class="fas fa-search"></i>
                </div>
                <input id="search" type="search" placeholder="Search User" aria-label="Search"
                    class="w-full rounded-md text-center font-medium placeholder-gray-500 shadow-sm focus:border-indigo-800 focus:ring-indigo-800 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" />
            </div>
        </div>
        <div class="relative flex justify-center">
            <div class="results-container relative"></div>
        </div>

        <form action="/users" method="POST" enctype="multipart/form-data" class="mx-auto my-3 max-w-4xl">
            @csrf
            <div id="elements" class="grid grid-cols-2 gap-6">
                <!-- Name -->
                <div class="mt-2">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name"
                        placeholder="{{ __('Masukkan Nama Pengguna') }}" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Username -->
                <div class="mt-2">
                    <x-input-label for="username" value="NIP" />
                    <x-text-input id="username" class="mt-1 block w-full" type="text" name="username"
                        autocomplete="username" :value="old('username')" required
                        placeholder="{{ __('Masukkan NIP/NIPH Pengguna') }}" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-2">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="email"
                        placeholder="{{ __('Masukkan Alamat Email') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-2">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="mt-1 block w-full" type="password" name="password"
                        autocomplete="new-password" placeholder="{{ __('Masukkan Kata Sandi') }}" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Contact User -->
                <div class="mt-2">
                    <x-input-label for="contact" :value="__('Contact')" />
                    <x-text-input id="contact" class="mt-1 block w-full" type="tel" name="contact"
                        :value="old('contact')" autocomplete="tel" placeholder="{{ __('Masukkan Kontak Pengguna') }}" />
                    <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                </div>

                <!-- User Role -->
                <div class="mt-2">
                    <x-input-label for="roles" :value="__('Role')" />
                    {{-- <select id="role" name="role"
                        class="mt-1 w-full rounded-md shadow-sm focus:border-indigo-800 focus:ring-indigo-800 dark:border-white dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        @foreach ($roles as $role)
                            <option value="" hidden {{ old('role') ? '' : 'selected' }}>Choose User Role
                            </option>
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select> --}}
                    <ul class="flex flex-col sm:flex-row">
                        @foreach ($roles as $role)
                            <li
                                class="-mt-px inline-flex w-full items-center gap-x-2.5 border bg-white px-4 py-3 text-sm font-medium text-gray-800 first:mt-0 first:rounded-t-lg last:rounded-b-lg dark:border-neutral-700 dark:bg-neutral-800 dark:text-white sm:-ms-px sm:mt-0 sm:first:rounded-es-lg sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-se-lg">
                                <div class="relative flex w-full items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="role-{{ $role->id }}" name="roles[]" type="checkbox"
                                            value="{{ $role->name }}"
                                            class="rounded border-gray-200 disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-800 dark:checked:border-blue-500 dark:checked:bg-blue-500 dark:focus:ring-offset-gray-800"
                                            {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                    </div>
                                    <label for="role-{{ $role->id }}"
                                        class="ms-3.5 block w-full text-sm text-gray-600 dark:text-neutral-500">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                </div>
            </div>

            <x-primary-button class="mt-8">
                {{ __('Daftarkan') }}
            </x-primary-button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const resultsContainer = document.querySelector('.results-container');
            const nameInput = document.getElementById('name');
            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            const token = '119961|e1jvJWYHODtLf4u15duHkFeb4qpPmuz97f2DhfiV';

            searchInput.addEventListener('input', function() {
                const query = searchInput.value;

                if (query.length > 2) {

                    const url =
                        `https://api-gerbang.itk.ac.id/api/siakad/pegawai/search?keyword=${encodeURIComponent(query)}`;

                    fetch(url, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Authorization': 'Bearer ' + token, // Masukkan token Anda di sini
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            resultsContainer.innerHTML = ''; // Bersihkan hasil sebelumnya

                            // Cek apakah ada pesan
                            if (data.message) {
                                resultsContainer.innerHTML =
                                    `<div class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-80 overflow-hidden rounded-md bg-white py-2 px-3 text-sm text-gray-500">${data.message}</div>`;
                            }

                            // Cek apakah data berhasil diambil
                            if (data.data && data.data.length > 0) {
                                const resultWrapper = document.createElement('div');
                                resultWrapper.classList.add('absolute', 'left-1/2', 'transform',
                                    '-translate-x-1/2', 'mt-2', 'w-80', 'overflow-hidden',
                                    'rounded-md', 'bg-white');

                                // Loop melalui setiap item di dalam data
                                data.data.forEach(item => {
                                    const emailItem = document.createElement('div');
                                    emailItem.classList.add('text-sm', 'cursor-pointer', 'py-2',
                                        'px-3', 'hover:bg-slate-100');

                                    // Gunakan data yang benar dari respons
                                    emailItem.innerHTML = `<p class="font-medium text-gray-600">${item.PE_Email}</p>
                                    <p class="text-gray-500">${item.PE_Nama}</p>`;

                                    // Tambahkan event listener untuk memasukkan data ke input saat diklik
                                    emailItem.addEventListener('click', function() {
                                        nameInput.value = item.PE_Nama;
                                        usernameInput.value = item.PE_Nip;
                                        emailInput.value = item.PE_Email;
                                        searchInput.value = '';
                                        resultsContainer.innerHTML = '';
                                    });
                                    resultWrapper.appendChild(emailItem);
                                });

                                resultsContainer.appendChild(resultWrapper);
                            } else {
                                resultsContainer.innerHTML =
                                    `<div class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-80 overflow-hidden rounded-md bg-white py-2 px-3 text-sm text-gray-500">Tidak ada data ditemukan</div>`;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });

                } else {
                    resultsContainer.innerHTML = ''; // Bersihkan jika input kurang dari 2 karakter
                }
            });
        });
    </script>
</x-app-layout>
