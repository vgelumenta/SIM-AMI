<x-app-layout>
    <div class="flex h-full w-full flex-col gap-2">

        <div class="flex items-center justify-between" aria-label="Breadcrumb">
            <ol class="inline-flex items-center text-lg">
                <li>
                    <div class="flex items-center">
                        <a class="mx-1 font-medium text-blue-800 dark:text-cool-gray-50">
                            Documents
                        </a>
                    </div>
                </li>
            </ol>
            <div class="flex items-center gap-x-2">
                @if (session('status'))
                    <div id="toast-success"
                        class="hidden w-full max-w-xs items-center rounded-sm border-green-400 bg-white px-3 py-1.5 text-gray-500 shadow dark:bg-gray-800 dark:text-gray-400 md:flex"
                        role="alert">
                        <div
                            class="inline-flex flex-shrink-0 items-center justify-center rounded-lg bg-green-100 p-0.5 text-green-400 dark:bg-green-800 dark:text-green-200">
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="sr-only">Check icon</span>
                        </div>
                        <div class="mx-2 text-sm font-medium">{{ session('success') }}</div>
                        <button type="button"
                            class="ms-auto inline-flex items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                            data-dismiss-target="#toast-success" aria-label="Close">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif
                <a href="/documents/create"
                    class="inline-block whitespace-nowrap rounded-sm border-2 border-green-400 bg-green-400 px-3 py-1 text-sm font-medium text-white transition hover:shadow-outline-green">
                    <i class="far fa-plus-square mr-2"></i>Add Document
                </a>
            </div>
        </div>

        <div class="h-[90%]" x-data="{ openTab: window.location.hash ? window.location.hash.substring(1) : '' }" x-init="openTab = window.location.hash ? window.location.hash.substring(1) : '';
            window.addEventListener('hashchange', () => {
                openTab = window.location.hash ? window.location.hash.substring(1) : '';
            });">
            <ul class="flex">
                <li class="-mb-px mr-1">
                    <div @click.prevent="openTab = ''; window.location.hash = ''"
                        :class="openTab === '' ?
                            'text-indigo-800 dark:text-purple-400 border-l border-t border-r border-indigo-800 dark:border-gray-500 rounded-t' :
                            'text-gray-500 dark:text-gray-400 hover:text-green-400 dark:hover:text-gray-200 hover:border-l hover:border-t hover:border-r hover:border-indigo-800 dark:hover:border-purple-500 rounded-t'"
                        class="inline-flex w-24 cursor-pointer justify-center bg-white p-1 font-semibold dark:bg-gray-700">
                        Documents</div>
                </li>
                <li class="-mb-px mr-1">
                    <div @click.prevent="openTab = 'drafts'; window.location.hash = 'drafts'"
                        :class="openTab === 'drafts' ?
                            'text-indigo-800 dark:text-purple-400 border-l border-t border-r border-indigo-800 dark:border-gray-500 rounded-t' :
                            'text-gray-500 dark:text-gray-400 hover:text-green-400 dark:hover:text-gray-200 hover:border-l hover:border-t hover:border-r hover:border-indigo-800 dark:hover:border-purple-500 rounded-t'"
                        class="inline-flex w-24 cursor-pointer justify-center bg-white p-1 font-semibold dark:bg-gray-700">
                        Drafts</div>
                </li>
            </ul>
            <div
                class="shadow-xs h-[90%] rounded-b rounded-r border border-indigo-800 bg-white p-2 dark:border-gray-500 dark:bg-gray-700">
                <div x-show="openTab === ''"
                    class="h-full overflow-auto rounded-sm scrollbar-thin dark:scrollbar-track-gray-400 dark:scrollbar-thumb-gray-700">
                    @if ($documents->count())
                        <table class="whitespace-no-wrap w-full">
                            <thead>
                                <tr class="sticky top-0 bg-blue-800 text-cool-gray-50">
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-32 py-2 text-left">Document Name</th>
                                    <th class="py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                    <tr
                                        class="border-b bg-white text-center hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:text-cool-gray-50">
                                        <td class="px-4 py-2">{{ $loop->iteration . '.' }}</td>
                                        <td class="px-32 py-2 text-left">{{ $document->name }}</td>
                                        <td class="grid gap-y-2 py-2 xl:block xl:space-x-2">

                                            <a href="{{ route('documents.show', $document) }}"
                                                class="inline-block rounded border border-blue-500 px-3 py-1 text-sm font-medium text-blue-500 transition hover:bg-blue-500 hover:text-white">
                                                <i class="fa-solid fa-eye"></i>
                                                Buka
                                            </a>
                                            <a href="{{ route('documents.edit', $document) }}"
                                                class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Ubah
                                            </a>
                                            @if ($document->can_be_deleted)
                                                <form action="{{ route('documents.destroy', $document) }}"
                                                    method="POST"
                                                    class="inline-block rounded border border-red-600 px-3 py-1 text-sm font-medium text-red-600 transition hover:bg-red-600 hover:text-white">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data?');">
                                                        <i class="fas fa-trash-alt"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">Tidak dapat dihapus</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex h-full items-center justify-center bg-white font-bold text-gray-500">
                            No Document found.
                        </div>
                    @endif
                </div>
                <div x-show="openTab === 'drafts'"
                    class="h-full overflow-auto rounded-sm scrollbar-thin dark:scrollbar-track-gray-400 dark:scrollbar-thumb-gray-700">
                    @if ($drafts->count())
                        <table class="whitespace-no-wrap w-full">
                            <thead>
                                <tr class="sticky top-0 bg-blue-800 text-cool-gray-50">
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-32 py-2 text-left">Document Name</th>
                                    <th class="py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drafts as $draft)
                                    <tr
                                        class="border-b bg-white text-center hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:text-cool-gray-50">
                                        <td class="px-4 py-2">{{ $loop->iteration . '.' }}</td>
                                        <td class="px-32 py-2 text-left">{{ $draft }}</td>
                                        <td class="grid gap-y-2 py-2 xl:block xl:space-x-2">
                                            <a href="{{ route('documents.editDraft', $draft) }}"
                                                class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                                <i class="fa fa-edit mr-1"></i>
                                                Ubah
                                            </a>
                                            <form action="{{ route('documents.destroyDraft', $draft) }}" method="POST"
                                                class="inline-block rounded border border-red-600 px-3 py-1 text-sm font-medium text-red-600 transition hover:bg-red-600 hover:text-white">
                                                @method('delete')
                                                @csrf
                                                <button
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex h-full items-center justify-center bg-white font-bold text-gray-500">
                            No Draft found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
