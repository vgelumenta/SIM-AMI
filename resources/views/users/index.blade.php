<x-app-layout>
    <div x-data="user()" class="flex h-full w-full flex-col gap-y-1 font-semibold">

        <div class="flex items-center justify-between py-1 text-blue-800 dark:text-cool-gray-50 md:text-lg">
            <ol class="flex items-center gap-x-1">
                <li>Users</li>
            </ol>
            <div class="flex items-center gap-x-2">
                <a href="/users/create"
                    class="inline-flex items-center gap-x-2 rounded-sm border-2 border-green-400 bg-green-400 px-2 py-1 text-sm text-white transition hover:shadow-outline-green">
                    <span class="hidden lg:block">Add User</span>
                    <i class="far fa-plus-square"></i>
                </a>
            </div>
        </div>

        <div
            class="h-[85%] w-full overflow-y-auto scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
            @if ($users->count())
                <table class="h-full w-full rounded-md bg-white dark:bg-gray-900">
                    <thead class="sticky top-0 z-10">
                        <tr class="border-b bg-blue-800 text-cool-gray-50">
                            <th class="py-2">#</th>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Last seen</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-800">
                                <td class="px-2 text-center">{{ $loop->iteration . '.' }}</td>
                                <td class="whitespace-nowrap py-2">
                                    <div class="flex items-center gap-3">
                                        <div class="relative h-8 w-8">
                                            <img class="h-full w-full rounded-full object-cover"
                                                src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random"
                                                alt="" loading="lazy" />
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                            </div>
                                        </div>
                                        <div>
                                            <h1>{{ $user->name }}{{ Auth::id() === $user->id ? ' (Anda)' : '' }}</h1>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $user->contact }}</td>
                                <td>
                                    <div class="flex flex-wrap items-center justify-center gap-1 text-xs">
                                        @foreach ($user->getRoleNames() as $role)
                                            @if ($role == 'PJM')
                                                <span
                                                    class="rounded-full bg-green-200 px-3 py-1 leading-tight text-green-700 dark:bg-green-700 dark:text-green-200">
                                                    {{ $role }}
                                                </span>
                                            @elseif ($role == 'Auditor')
                                                <span
                                                    class="rounded-full bg-yellow-200 px-3 py-1 leading-tight text-yellow-500 dark:bg-yellow-400 dark:text-yellow-200">
                                                    {{ $role }}
                                                </span>
                                            @elseif ($role == 'Auditee')
                                                <span
                                                    class="rounded-full bg-red-200 px-3 py-1 leading-tight text-red-700 dark:bg-red-700 dark:text-red-200">
                                                    {{ $role }}
                                                </span>
                                            @else
                                                <span
                                                    class="rounded-full bg-gray-200 px-3 py-1 leading-tight text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ $role }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-2 text-center">
                                    @if ($user->last_seen && $user->last_seen >= now()->subMinutes(3))
                                        <span
                                            class="rounded-full bg-teal-200 px-3 py-1 text-teal-500 dark:bg-teal-400 dark:text-teal-100">
                                            Online
                                        </span>
                                    @elseif ($user->last_seen)
                                        {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                    @else
                                        <span class="text-gray-600 dark:text-gray-400">Tidak pernah terlihat</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <form id="form-{{ $user->id }}" action="/users/{{ $user->id }}" method="POST"
                                        class="inline-block">
                                        @method('delete')
                                        @csrf

                                        <button type="button"
                                            class="rounded border border-red-600 px-3 py-1 text-sm text-red-600 transition hover:bg-red-600 hover:text-white"
                                            @click="openConfirm('Yakin ingin menghapus pengguna?', 'Data dan akses tidak dapat dikembalikan.', () => {
                                            document.getElementById('form-{{ $user->id }}').submit()
                                        });">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex h-full items-center justify-center">
                    <h6 class="text-gray-600 dark:text-white">Maaf data tidak ditemukan</h6>
                </div>
            @endif
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
    </div>

    <script>
        function user() {
            return {
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
