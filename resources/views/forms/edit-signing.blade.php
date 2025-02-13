<x-app-layout>
    <form x-data="user()" id="form" action="{{ route('forms.updateSigning', $form) }}"
        enctype="multipart/form-data" method="POST" class="flex h-full w-full flex-col gap-y-1 font-semibold">
        @csrf
        @method('PUT')

        <div class="flex items-center justify-between py-1 text-indigo-700 dark:text-cool-gray-50 md:text-lg">
            <ol class="flex items-center gap-x-1">
                <li>
                    <a href="/forms" class="hover:underline">
                        Form
                    </a>
                </li>
                <li>
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li class="truncate" style="max-width: 6rem;">{{ $form->document->name }}</li>
                <li>
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-width="2" viewBox="0 0 6 10">
                        <path d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li class="xl:hidden">{{ $form->unit->code }}</li>
                <li class="hidden xl:block">{{ $form->unit->name }}</li>
                <li class="hidden xl:block">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-width="2" viewBox="0 0 6 10">
                        <path d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li class="hidden xl:block">Signing</li>
            </ol>

            <div class="flex items-center gap-x-2">

                <button type="button" @click="openContact()"
                    class="inline-flex gap-x-1 rounded-sm border-2 border-green-400 bg-green-400 p-1 text-sm text-white transition hover:shadow-outline-green">
                    <span class="hidden lg:block">Contact</span>
                    <svg class="w-5" data-slot="icon" fill="none" stroke-width="2" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z">
                        </path>
                    </svg>
                </button>

                <div x-show="isContactOpen"
                    class="fixed inset-0 z-40 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
                    <!-- Modal -->
                    <div x-show="isContactOpen" @click.away="closeContact()" @keydown.escape="closeContact()"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 transform translate-y-1/2"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0 transform translate-y-1/2"
                        class="w-full space-y-3 overflow-hidden rounded-t-lg bg-white p-3 text-indigo-800 dark:bg-gray-700 dark:text-cool-gray-50 sm:m-4 sm:max-w-xl sm:rounded-lg"
                        id="modal-contact">
                        <header class="flex justify-between">
                            <div class="ms-5">
                                Contact users
                            </div>
                            <button type="button"
                                class="inline-flex h-6 w-6 items-center justify-center rounded text-gray-400 transition-colors duration-150 hover:text-gray-700 dark:hover:text-gray-100"
                                @click="closeContact()">
                                <svg class="w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z">
                                    </path>
                                </svg>
                            </button>
                        </header>
                        <!-- Modal body -->
                        <div class="grid grid-cols-4">
                            <div class="col-span-2 text-center">
                                Auditee
                            </div>
                            <div class="col-span-2 text-center">
                                Auditor
                            </div>
                        </div>
                        <div
                            class="grid max-h-[55vh] grid-cols-4 overflow-y-auto overflow-x-hidden text-gray-700 scrollbar-thin dark:text-cool-gray-50 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                            <div class="col-span-2 flex flex-col gap-4 px-3">
                                @foreach ($auditees as $auditee)
                                    <div class="flex flex-col gap-1 text-sm">
                                        <div> {{ $auditee->position }} </div>
                                        <div class="flex items-center">
                                            <div class="relative mr-3 h-9 w-9 flex-shrink-0">
                                                <img class="h-full w-full rounded-full object-cover"
                                                    src="https://ui-avatars.com/api/?name={{ $auditee->user->name }}&background=random"
                                                    alt="" loading="lazy" />
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="truncate">{{ $auditee->user->name }}</div>
                                                <div class="truncate text-gray-500 dark:text-gray-400">
                                                    {{ $auditee->user->contact }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-span-2 flex flex-col gap-4 px-3">
                                @foreach ($auditors as $auditor)
                                    <div class="flex flex-col gap-1 text-sm">
                                        <div> {{ $auditor->position }} </div>
                                        <div class="flex items-center">
                                            <div class="relative mr-3 h-9 w-9 flex-shrink-0">
                                                <img class="h-full w-full rounded-full object-cover"
                                                    src="https://ui-avatars.com/api/?name={{ $auditor->user->name }}&background=random"
                                                    alt="" loading="lazy" />
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="truncate">{{ $auditor->user->name }}</div>
                                                <div class="truncate text-gray-500 dark:text-gray-400">
                                                    {{ $auditor->user->contact }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <footer class="-mx-6 flex flex-row items-center justify-end px-6 pt-2">
                            <button @click="closeContact()" type="button"
                                class="w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm text-white transition-colors duration-150 hover:bg-blue-800 focus:shadow-outline-indigo sm:w-auto sm:px-4 sm:py-2">
                                Close
                            </button>
                        </footer>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="flex h-[85%] flex-col items-center gap-8 overflow-y-auto rounded-md bg-white px-4 pt-24 shadow-lg scrollbar-thin dark:bg-gray-900 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">

            <header class="text-center">
                <h2 class="text-lg text-gray-900 dark:text-white">
                    {{ __('Lampirkan Laporan Hasil Audit') }}
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Export Hasil dan Unggah Laporan yang telah ditandatangani') }}
                </p>
            </header>

            <div class="mx-auto max-w-4xl">
                <div class="flex grid-cols-2 gap-6">
                    <!-- Export -->
                    <div class="space-y-1 text-sm">
                        <label for="time" class="text-gray-900 dark:text-white">{{ __('Export') }}</label>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('forms.export', $form) }}"
                                class="w-full inline-block text-center rounded-md border border-red-600 p-2.5 text-sm font-medium text-red-600 transition hover:bg-red-600 hover:text-white">
                                {{-- <i class="fa-solid fa-file-word fa-xl"></i> --}}
                                <i class="fas fa-file-pdf fa-xl"></i>
                            </a>
                        </div>
                        @if ($errors->has('time'))
                            <p class="text-red-500">{{ $errors->first('time') }}</p>
                        @endif
                    </div>
                    <!-- Document -->
                    <div class="space-y-1 text-sm">
                        <label for="document" class="text-gray-900 dark:text-white">{{ __('Document') }}</label>
                        <input
                            class="w-full cursor-pointer rounded-md border pr-4 border-gray-300 bg-gray-50 text-sm text-gray-900 shadow-sm focus:border-indigo-800 focus:outline-none focus:ring-indigo-800 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400 dark:focus:border-purple-500 dark:focus:ring-purple-500"
                            id="document" name="document" type="file">
                        @if ($errors->has('document'))
                            <p class="text-red-500">{{ $errors->first('document') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between py-2">
            <a href="/forms"
                class="rounded-md bg-gray-500 px-4 py-2 text-xs uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:shadow-outline-gray">
                {{ __('Back') }}
            </a>
            <button type="button"
                class="rounded-md bg-blue-800 px-4 py-2 text-xs uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-700 focus:shadow-outline-blue"
                @click="openConfirm('Yakin ingin mengirim?', 'Pastikan data sudah benar.', () => {
                            document.getElementById('form').submit()
                        });">
                {{ __('Submit') }}
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
                },isContactOpen: false,
                openContact() {
                    this.isContactOpen = true;
                    this.focusTrap = focusTrap(document.querySelector('#modal-contact'));
                },
                closeContact() {
                    this.isContactOpen = false
                    this.focusTrap();
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
