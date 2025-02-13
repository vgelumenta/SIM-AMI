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
        @if ($userRole == 'PJM')
            <div class="flex items-center">
                <a href="/forms/create"
                    class="inline-block rounded-sm border-2 border-green-400 bg-green-400 px-3 py-1 text-sm font-medium text-white transition hover:shadow-outline-green">
                    <i class="far fa-plus-square mr-2"></i>Add Form
                </a>
            </div>
        @endif
    </div>

    <div
        class="h-[545px] overflow-auto rounded-sm font-normal scrollbar-thin dark:scrollbar-track-gray-400 dark:scrollbar-thumb-gray-700">
        @if ($forms->count())
            <table class="whitespace-no-wrap w-full">
                <thead>
                    <tr class="sticky top-0 bg-blue-800 text-cool-gray-50">
                        <th class="px-4 py-2">#</th>
                        <th class="py-2 text-left">Forms Name</th>
                        <th class="p-2">Period</th>
                        <th class="px-12 py-2 text-left">Stage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        {{-- @php
                            // Periksa apakah user memiliki akses sebagai Pimpinan atau PIC
                            $auditee = $form->formAccesses->contains(function ($access) {
                                return $access->user_id === auth()->id() &&
                                    ($access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false);
                            });

                            $auditor = $form->formAccesses->contains(function ($access) {
                                return $access->user_id === auth()->id() &&
                                    ($access->position === 'Ketua' || $access->position === 'Anggota');
                            });
                        @endphp --}}
                        <tr
                            class="border-b bg-white text-center hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:text-cool-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration . '.' }}</td>
                            <td class="py-2 text-left">{{ $form->unit->name }}</td>
                            <td class="p-2">{{ $form->document->name }}</td>
                            <td class="px-8 py-2 text-left">{{ "Tahap {$form->stage_id} | {$form->stage->name}" }}</td>
                            <td
                                class="{{ $userRole == 'PJM' ? 'justify-end' : 'justify-center' }} flex flex-col items-center gap-2 px-16 py-2 lg:flex-row">
                                @if (($form->stage_id === 5 && $form->meeting) || ($form->stage_id === 7 && $form->signing))
                                    <div class="hs-tooltip font-semibold">
                                        <svg class="hs-tooltip-toggle {{ $form->signing_verification === 0 ? 'hover:text-red-600 dark:text-red-500 dark:hover:text-red-500' : 'hover:text-yellow-300 dark:hover:text-yellow-300' }} size-6 cursor-pointer text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z">
                                            </path>
                                        </svg>
                                        <div style="text-align: justify;"
                                            class="hs-tooltip-content invisible absolute z-10 hidden max-w-xs rounded-lg border border-gray-100 bg-white p-3 text-gray-600 opacity-0 shadow-md transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">
                                            @if ($form->meeting_verification === 0 || $form->signing_verification === 0)
                                                <h3 class="font-semibold text-red-500">
                                                    Laporan ditolak</h3>
                                            @else
                                                <h3 class="font-semibold text-yellow-300">
                                                    Verifikasi Laporan</h3>
                                            @endif

                                            @if ($form->verification_info)
                                                <p class="text-sm text-gray-500">
                                                    {{ $form->verification_info }}
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-500">
                                                    Menunggu verifikasi
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if ($form->stage_id === 1 && $userRole === 'Auditee' && $form->auditeeAccess)
                                    <a href="{{ route('forms.editSubmission', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Isi Laporan
                                    </a>
                                @elseif ($form->stage_id === 2 && $userRole === 'Auditor' && $form->auditorAccess)
                                    <a href="{{ route('forms.editAssessment', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Periksa Laporan
                                    </a>
                                @elseif ($form->stage_id === 3 && $userRole === 'Auditee' && $form->auditeeAccess)
                                    <a href="{{ route('forms.editFeedback', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Berikan Tanggapan
                                    </a>
                                @elseif ($form->stage_id === 4 && $userRole === 'Auditor' && $form->auditorAccess)
                                    <a href="{{ route('forms.editValidation', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Validasi Hasil Audit
                                    </a>
                                @elseif ($form->stage_id === 5 && $userRole === 'Auditee' && $form->auditeeAccess)
                                    <a href="{{ route('forms.editMeeting', $form) }}"
                                        class="inline-flex gap-1 rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                                            </path>
                                        </svg>
                                        Lampirkan RTM
                                    </a>
                                @elseif ($form->stage_id === 5 && $form->meeting && $form->meeting_verification === null && $userRole === 'PJM')
                                    <a href="{{ route('forms.editMeetingVerification', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Verifikasi RTM
                                    </a>
                                @elseif ($form->stage_id === 6 && $userRole === 'Auditee' && $form->auditeeAccess)
                                    <a href="{{ route('forms.editPlanning', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Isi RTL
                                    </a>
                                @elseif ($form->stage_id === 7 && $userRole === 'Auditee' && $form->auditeeAccess)
                                    <a href="{{ route('forms.editSigning', $form) }}"
                                        class="inline-flex gap-1 rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                                            </path>
                                        </svg>
                                        Unggah Laporan
                                    </a>
                                @elseif ($form->stage_id === 7 && $form->signing && $form->signing_verification === null && $userRole === 'PJM')
                                    <a href="{{ route('forms.editSigningVerification', $form) }}"
                                        class="inline-block rounded border border-yellow-300 px-3 py-1 text-sm font-medium text-yellow-300 transition hover:bg-yellow-300 hover:text-white">
                                        <i class="fa fa-edit mr-1"></i>
                                        Verifikasi Laporan
                                    </a>
                                @elseif ($form->stage_id === 8)
                                    <a href="{{ route('forms.showReport', $form) }}"
                                        class="inline-block rounded border border-green-400 px-3 py-1 text-sm font-medium text-green-400 transition hover:bg-green-400 hover:text-white">
                                        <i class="fa-solid fa-eye"></i>
                                        Lihat Laporan
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
