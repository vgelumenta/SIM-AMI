<x-app-layout>

    <div
        class="mb-4 flex items-center justify-between text-sm font-medium text-blue-800 dark:text-cool-gray-50 md:text-lg">
        <ol class="flex items-center">
            <li>
                <a class="mx-1">
                    Users
                </a>
            </li>
        </ol>
        <div class="flex items-center gap-x-2">
            @if (session('status'))
                <div id="toast-success"
                    class="hidden w-full max-w-xs items-center rounded-sm border-green-400 bg-white px-3 py-1.5 text-gray-500 shadow dark:bg-gray-800 dark:text-gray-400 md:flex"
                    role="alert">
                    <div
                        class="inline-flex flex-shrink-0 items-center justify-center rounded-lg bg-green-100 p-0.5 text-green-400 dark:bg-green-800 dark:text-green-200">
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        <span class="sr-only">Check icon</span>
                    </div>
                    <div class="mx-2 text-sm font-medium">{{ session('status') }}</div>
                    <button type="button"
                        class="ms-auto inline-flex items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                        data-dismiss-target="#toast-success" aria-label="Close">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            <a href="/users/create"
                class="inline-block whitespace-nowrap rounded-sm border-2 border-green-400 bg-green-400 px-3 py-1 text-sm font-medium text-white transition hover:shadow-outline-green">
                <i class="far fa-plus-square mr-2"></i>Add User
            </a>
        </div>
    </div>

    <div class="container mx-auto overflow-y-auto rounded-sm pb-4">
        @if ($users->count())
            <table class="min-w-full bg-white shadow-md">
                <thead>
                    <tr class="border-b bg-blue-800 text-cool-gray-50">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Last seen</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b text-center text-sm hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration . '.' }}</td>
                            <td class="px-4 py-2 text-start">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-end">{{ $user->email }}</td>
                            <td class="flex flex-row items-center gap-0.5 px-4 py-2 text-xs">
                                @foreach ($user->getRoleNames() as $role)
                                    @if ($role == 'PJM')
                                        <span
                                            class="rounded-full bg-green-200 px-3 py-1 font-semibold leading-tight text-green-700 dark:bg-green-700 dark:text-green-200">
                                            {{ $role }}
                                        </span>
                                    @elseif ($role == 'Auditor')
                                        <span
                                            class="rounded-full bg-yellow-200 px-3 py-1 font-semibold leading-tight text-yellow-400 dark:bg-yellow-400 dark:text-yellow-200">
                                            {{ $role }}
                                        </span>
                                    @elseif ($role == 'Auditee')
                                        <span
                                            class="rounded-full bg-red-200 px-3 py-1 font-semibold leading-tight text-red-700 dark:bg-red-700 dark:text-red-200">
                                            {{ $role }}
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-gray-200 px-3 py-1 font-semibold leading-tight text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                            {{ $role }}
                                        </span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-4 py-2">
                                @if (Cache::has('user-' . $user->id . '-is-online'))
                                    <span
                                        class="rounded-full bg-teal-200 px-3 py-1 text-sm text-teal-500 dark:bg-teal-400 dark:text-teal-100">
                                        Online
                                    </span>
                                @else
                                    <span
                                        class="rounded-full bg-gray-200 px-3 py-1 text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-100">
                                        Offline
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if (Auth::id() !== $user->id && $user->last_seen)
                                    {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <form action="/users/{{ $user->id }}" method="POST" class="inline-block">
                                    @method('delete')
                                    @csrf
                                    <button onclick="return confirm('Apakah Anda yakin ingin menghapus data?');"
                                        class="rounded border border-red-600 px-3 py-1 text-sm font-medium text-red-600 transition hover:bg-red-600 hover:text-white">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h6 class="text-gray-500">Maaf data tidak ditemukan</h6>
        @endif
    </div>

</x-app-layout>
