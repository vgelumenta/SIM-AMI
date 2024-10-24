<x-app-layout>
    <div class="mb-4 flex items-center justify-between" aria-label="Breadcrumb">
        <ol class="inline-flex items-center text-lg">
            <li>
                <div class="flex items-center">
                    <a class="mx-1 font-medium text-blue-800 dark:text-cool-gray-50">
                        Forms
                    </a>
                </div>
            </li>
        </ol>
        <div class="flex items-center">
            <a href="/forms/create"
                class="inline-block rounded-sm border-2 border-green-400 bg-green-400 px-3 py-1 text-sm font-medium text-white transition hover:shadow-outline-green">
                <i class="far fa-plus-square mr-2"></i>Add Form
            </a>
        </div>
    </div>

    <div
        class="h-[545px] overflow-auto rounded-sm scrollbar-thin dark:scrollbar-track-gray-400 dark:scrollbar-thumb-gray-700">
        @if ($forms->count())
            <table class="whitespace-no-wrap w-full">
                <thead>
                    <tr class="sticky top-0 bg-blue-800 text-cool-gray-50">
                        <th class="px-4 py-2">#</th>
                        <th class="py-2 text-left">Forms Name</th>
                        <th class="p-2 text-left">Period</th>
                        <th class="p-2 text-left">Stage</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        <tr
                            class="border-b bg-white text-center hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:text-cool-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration . '.' }}</td>
                            <td class="py-2 text-left">{{ $form->unit->name }}</td>
                            <td class="p-2 text-left">{{ $form->document->name }}</td>
                            <td class="p-2 text-left">{{ "Tahap {$form->stage_id} | {$form->stage->name}" }}</td>
                            <td class="grid gap-y-2 py-2 xl:block xl:space-x-2">
                                @if ($form->stage_id == 1 && $userRole == 'Auditee')
                                    <a href="{{ route('forms.editSubmission', $form) }}"
                                        class="inline-block rounded border border-blue-500 px-3 py-1 text-sm font-medium text-blue-500 transition hover:bg-blue-500 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Isi Laporan
                                    </a>
                                @elseif ($form->stage_id == 2 && $userRole == 'Auditor')
                                    <a href="{{ route('forms.editAsessment', $form) }}"
                                        class="inline-block rounded border border-blue-500 px-3 py-1 text-sm font-medium text-blue-500 transition hover:bg-blue-500 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Periksa Laporan
                                    </a>
                                @elseif ($form->stage_id == 3 && $userRole == 'Auditee')
                                    <a href="{{ route('forms.editFeedback', $form) }}"
                                        class="inline-block rounded border border-blue-500 px-3 py-1 text-sm font-medium text-blue-500 transition hover:bg-blue-500 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Berikan Tanggapan
                                    </a>
                                @elseif ($form->stage_id == 4 && $userRole == 'Auditor')
                                    <a href="{{ route('forms.editVerification', $form) }}"
                                        class="inline-block rounded border border-blue-500 px-3 py-1 text-sm font-medium text-blue-500 transition hover:bg-blue-500 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Berikan Verifikasi Audit
                                    </a>
                                @else
                                    <a href="{{ route('forms.show', $form) }}"
                                        class="inline-block rounded border border-blue-500 px-3 py-1 text-sm font-medium text-blue-500 transition hover:bg-blue-500 hover:text-white">
                                        <i class="fa-solid fa-eye"></i>
                                        Lihat Audit
                                    </a>
                                @endif
                                @if ($userRole == 'PJM')
                                    {{-- <a href="{{ route('forms.edit', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Ubah
                                    </a> --}}
                                    <form action="{{ route('forms.destroy', $form) }}" method="POST"
                                        class="inline-block rounded border border-red-600 px-3 py-1 text-sm font-medium text-red-600 transition hover:bg-red-600 hover:text-white">
                                        @method('delete')
                                        @csrf
                                        <button onclick="return confirm('Apakah Anda yakin ingin menghapus data?');">
                                            <i class="fas fa-trash-alt"></i>
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="flex h-[540px] items-center justify-center bg-white font-bold text-gray-500">
                No Forms found.
            </div>
        @endif
    </div>
</x-app-layout>
