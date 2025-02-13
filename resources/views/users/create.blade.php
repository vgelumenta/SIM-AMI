<x-app-layout>
    <form x-data="user()" id="form" action="/users" method="POST"
        class="flex h-full w-full flex-col gap-y-1 font-semibold">
        @csrf

        <div class="flex items-center justify-between py-1 text-blue-800 dark:text-cool-gray-50 md:text-lg">
            <ol class="flex items-center gap-x-1">
                <li>
                    <a href="/users" class="hover:underline">
                        Users
                    </a>
                </li>
                <li>
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-width="2" viewBox="0 0 6 10">
                        <path d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li>Create</li>
            </ol>
        </div>

        <div
            class="flex h-[85%] flex-col items-center justify-center gap-6 overflow-y-auto rounded-md bg-white px-4 shadow-lg scrollbar-thin dark:bg-gray-900 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">

            <header class="text-center">
                <h2 class="text-lg text-gray-900 dark:text-white">
                    {{ __('Daftarkan Pengguna Baru') }}
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Masukkan pencarian untuk mendaftarkan pengguna baru.') }}
                </p>
            </header>

            <!-- Search input -->
            <div class="relative mx-12 flex max-w-xl items-center justify-center lg:mx-32">
                <div class="relative focus-within:text-blue-800">
                    <div class="absolute inset-y-0 flex items-center px-4 text-gray-900 dark:text-cool-gray-50">
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z">
                            </path>
                        </svg>
                    </div>
                    <input x-model="keyword" @input="search()" type="search" placeholder="Search User" autofocus
                        aria-label="Search"
                        class="w-full rounded-md ps-10 text-center placeholder-gray-500 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" />
                </div>
                <div x-show="results.length || message"
                    class="absolute top-full mt-1 max-h-56 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg scrollbar-thin dark:bg-gray-700 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                    <!-- Item Hasil -->
                    <template x-for="item in results" :key="item.PE_Email">
                        <div @click="selectUser(item)"
                            class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                            <span x-text="item.PE_Nama"></span>
                        </div>
                    </template>
                    <!-- Pesan Tidak Ada Hasil -->
                    <template x-if="message">
                        <div class="px-4 py-2 text-center text-sm text-gray-500" x-text="message"></div>
                    </template>
                </div>
            </div>

            <div class="mx-auto max-w-4xl">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-1 text-sm">
                        <label for="name" class="text-gray-900 dark:text-white">{{ __('Name') }}</label>
                        <input id="name" readonly
                            class="w-full rounded-md text-sm placeholder-gray-500 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            type="text" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('Nama Pengguna') }}" />
                        @if ($errors->has('name'))
                            <p class="text-red-500">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <!-- Username -->
                    <div class="space-y-1 text-sm">
                        <label for="username" class="text-gray-900 dark:text-white">{{ __('Username') }}</label>
                        <input id="username" readonly
                            class="w-full rounded-md text-sm placeholder-gray-500 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            type="text" name="username" value="{{ old('username') }}"
                            placeholder="{{ __('NIP/NIPH Pengguna') }}" />
                        @if ($errors->has('username'))
                            <p class="text-red-500">{{ $errors->first('username') }}</p>
                        @endif
                    </div>

                    <!-- Email -->
                    <div class="space-y-1 text-sm">
                        <label for="email" class="text-gray-900 dark:text-white">{{ __('Email') }}</label>
                        <input id="email" readonly
                            class="w-full rounded-md text-sm placeholder-gray-500 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            type="text" name="email" value="{{ old('email') }}"
                            placeholder="{{ __('Email Pengguna') }}" />
                        @if ($errors->has('email'))
                            <p class="text-red-500">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <!-- Contact User -->
                    <div class="space-y-1 text-sm">
                        <label for="contact" class="text-gray-900 dark:text-white">{{ __('Contact') }}</label>
                        <input id="contact"
                            class="w-full rounded-md text-sm placeholder-gray-500 dark:border-white dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            type="text" name="contact" value="{{ old('contact') }}"
                            placeholder="{{ __('Kontak Pengguna') }}" />
                        @if ($errors->has('contact'))
                            <p class="text-red-500">{{ $errors->first('contact') }}</p>
                        @endif
                    </div>

                    <!-- User Role -->
                    <div class="space-y-1 text-sm">
                        <label for="role" class="text-gray-900 dark:text-white">{{ __('Role') }}</label>
                        <ul class="flex flex-col sm:flex-row">
                            @foreach ($roles as $role)
                                <li
                                    class="-mt-px inline-flex w-full items-center gap-x-2.5 border border-gray-500 px-4 py-3 text-sm font-medium text-gray-900 first:mt-0 first:rounded-t-lg last:rounded-b-lg dark:border-white dark:bg-gray-700 sm:-ms-px sm:mt-0 sm:first:rounded-es-lg sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-se-lg">
                                    <div class="relative flex w-full items-start">
                                        <div class="flex h-5 items-center">
                                            <input id="role-{{ $role->id }}" name="roles[]" type="checkbox"
                                                value="{{ $role->name }}"
                                                class="rounded border-gray-500 disabled:opacity-50 dark:border-white dark:bg-gray-700 dark:checked:border-blue-500 dark:checked:bg-blue-500 dark:focus:ring-offset-gray-800"
                                                {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                        </div>
                                        <label for="role-{{ $role->id }}"
                                            class="ms-3.5 block w-full text-sm text-gray-900 dark:text-white">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if ($errors->has('roles'))
                            <p class="text-red-500">{{ $errors->first('roles') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between py-2">
            <a href="/users"
                class="rounded-md bg-gray-500 px-4 py-2 text-xs uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:shadow-outline-gray">
                {{ __('Back') }}
            </a>
            <button type="button"
                class="rounded-md bg-blue-800 px-4 py-2 text-xs uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-700 focus:shadow-outline-blue"
                @click="openConfirm('Yakin ingin menambah pengguna?', 'Pastikan data sudah benar.', () => {
                            document.getElementById('form').submit()
                        });">
                {{ __('Submit') }}
                <input type="hidden" name="action" value="submit">
            </button>
        </div>

        <div x-show="isConfirmOpen"
            class="fixed inset-0 z-50 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
            <!-- Modal -->
            <div x-show="isConfirmOpen" @click.away="closeConfirm()" @keydown.escape="closeConfirm()"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0 transform translate-y-1/2"
                class="w-full space-y-4 overflow-hidden rounded-t-lg bg-white p-4 dark:bg-gray-800 sm:max-w-xl sm:rounded-lg"
                id="confirm">
                <header class="flex justify-end">
                    <button type="button"
                        class="inline-flex h-6 w-6 items-center justify-center rounded text-gray-400 transition-colors duration-150 hover:text-gray-700 dark:hover:text-gray-100"
                        @click="closeConfirm()">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z">
                            </path>
                        </svg>
                    </button>
                </header>
                <!-- Modal body -->
                <div class="m-4 space-y-2 text-gray-700 dark:text-gray-300">
                    <!-- Modal title -->
                    <p x-text="confirmTitle" class="text-lg"></p>
                    <!-- Modal description -->
                    <p x-text="confirmText"></p>
                </div>
                <footer
                    class="-m-4 flex flex-col items-center space-y-4 px-6 py-3 text-sm dark:bg-gray-800 sm:flex-row sm:justify-end sm:space-x-6 sm:space-y-0">
                    <button type="button" @click="closeConfirm"
                        class="w-full rounded-lg border border-gray-300 p-3 tracking-widest text-gray-600 transition-colors duration-150 hover:border-gray-500 focus:border-gray-500 focus:shadow-outline-gray dark:text-white sm:w-auto">
                        Cancel
                    </button>
                    <button type="button" @click="confirmAction(); closeConfirm()"
                        class="w-full rounded-lg bg-red-700 p-3 tracking-widest text-white transition-colors duration-150 hover:bg-red-600 focus:shadow-outline-red sm:w-auto">
                        Accept
                    </button>
                </footer>
            </div>
        </div>
    </form>

    <script>
        function user() {
            return {
                keyword: '', // Keyword input pengguna
                results: [], // Data hasil pencarian
                message: '', // Pesan error atau status

                // Fungsi untuk melakukan pencarian
                search() {
                    if (this.keyword.length > 2) {
                        fetch(`/getUser?keyword=${encodeURIComponent(this.keyword)}`)
                            .then(response => {
                                if (!response.ok) throw new Error('Failed to fetch data');
                                return response.json();
                            })
                            .then(data => {
                                this.results = data.data || [];
                                this.message = this.results.length === 0 ? 'No results found' : '';
                            })
                            .catch(error => {
                                console.error(error);
                                this.message = 'Error fetching data';
                                this.results = [];
                            });
                    } else {
                        this.results = [];
                        this.message = '';
                    }
                },

                // Fungsi untuk memilih user dari hasil pencarian
                selectUser(item) {
                    document.getElementById('name').value = item.PE_Nama;
                    document.getElementById('username').value = item.PE_Nip;
                    document.getElementById('email').value = item.PE_Email;
                    this.clearResults();
                },

                // Fungsi untuk menghapus hasil pencarian
                clearResults() {
                    this.results = [];
                    this.message = '';
                    this.keyword = '';
                },
                isConfirmOpen: false,
                confirmTitle: '',
                confirmText: '',
                confirmAction: null,
                openConfirm(title, text, action) {
                    this.confirmTitle = title;
                    this.confirmText = text;
                    this.confirmAction = action;
                    this.isConfirmOpen = true;
                    this.focusTrap = focusTrap(document.querySelector('#confirm'))
                },
                closeConfirm() {
                    this.isConfirmOpen = false
                    this.focusTrap();
                },
                confirmAction() {
                    this.confirmAction()
                    this.closeConfirm()
                },
            };
        }
    </script>
</x-app-layout>
