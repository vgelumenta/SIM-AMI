<x-app-layout>
    <form action="{{ route('forms.updateSubmission', $form) }}" method="POST" class="flex h-full w-full flex-col">
        @csrf
        @method('PUT')

        <div
            class="mb-3 flex items-start justify-between gap-x-2 font-semibold text-blue-800 dark:text-cool-gray-50 sm:text-lg">
            <ol class="flex items-center gap-x-2">
                <li>
                    <a href="/forms" class="hover:underline">
                        Submission
                    </a>
                </li>
                <li>
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li>
                    <input type="text" value="{{ $form->document->name }}"
                        style="width: calc({{ strlen($form->document->name) }}ch);" readonly
                        class="border-0 border-indigo-800 bg-transparent p-0 font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400 sm:text-lg" />
                </li>
                <li>
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li>
                    <input type="text" value="{{ $form->unit->name }}"
                        style="width: calc({{ strlen($form->unit->name) }}ch - 1ch);" readonly
                        class="border-0 border-indigo-800 bg-transparent p-0 font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400 sm:text-lg" />
                </li>
            </ol>

            <div id="accordion-open" data-accordion="open">
                <h2 id="accordion-open-heading-1">
                    <button type="button" class="flex w-full items-center justify-end gap-3 sm:text-lg"
                        data-accordion-target="#accordion-open-body-1" aria-expanded="false"
                        aria-controls="accordion-open-body-1">
                        <span class="flex items-center">
                            {{-- <svg class="me-2 h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg> --}}
                            <svg class="me-2 h-7 w-7 shrink-0" data-slot="icon" fill="none" stroke-width="1.5"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z">
                                </path>
                            </svg>
                            Contact
                        </span>
                        <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
            </div>

            @if ($errors->any())
                <div class="flex items-center gap-x-2">
                    <div id="toast-success"
                        class="hidden w-full max-w-xs items-center rounded-sm border-green-400 bg-white px-3 py-1.5 text-gray-500 shadow dark:bg-gray-800 dark:text-gray-400 lg:flex"
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
                        <div class="mx-2 text-sm font-medium">{{ $errors->first() }}</div>
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
                </div>
            @endif
        </div>
        <div id="accordion-open-body-1" class="hidden p-4" aria-labelledby="accordion-open-heading-1">
            <table class="w-full border-collapse">
                <td>
                    <div class="flex w-full justify-center md:px-20">
                        <ul class="space-y-3">
                            <li>
                                <input value="Pimpinan" disabled
                                    class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                            </li>
                            <li>
                                <input value="PIC" disabled
                                    class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                            </li>
                        </ul>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <div class="relative flex items-center">
                                    <input disabled placeholder="No access"
                                        value="{{ optional($formAccesses->firstWhere('position', 'Pimpinan'))->user->name ?? '' }}"
                                        class="w-full border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                    <input disabled placeholder="No contact"
                                        value="{{ optional($formAccesses->firstWhere('position', 'Pimpinan'))->user->contact ?? '' }}"
                                        class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                </div>
                            </li>
                            <li class="flex items-center">
                                <div class="relative flex items-center">
                                    <input disabled placeholder="No access"
                                        value="{{ optional($formAccesses->firstWhere('position', 'PIC'))->user->name ?? '' }}"
                                        class="w-full border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                    <input disabled placeholder="No contact"
                                        value="{{ optional($formAccesses->firstWhere('position', 'PIC'))->user->contact ?? '' }}"
                                        class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </td>
                <td>
                    <div class="flex w-full md:px-20">
                        <ul class="space-y-3">
                            <li>
                                <input value="Ketua" disabled
                                    class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                            </li>
                            <li>
                                <input value="Anggota" disabled
                                    class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                            </li>
                        </ul>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <div class="relative flex items-center">
                                    <input disabled placeholder="No access"
                                        value="{{ optional($formAccesses->firstWhere('position', 'Ketua'))->user->name ?? '' }}"
                                        class="w-full border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                    <input disabled placeholder="No contact"
                                        value="{{ optional($formAccesses->firstWhere('position', 'Ketua'))->user->contact ?? '' }}"
                                        class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                </div>
                            </li>
                            <li class="flex items-center">
                                <div class="relative flex items-center">
                                    <input disabled placeholder="No access"
                                        value="{{ optional($formAccesses->firstWhere('position', 'Anggota'))->user->name ?? '' }}"
                                        class="w-full border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                    <input disabled placeholder="No contact"
                                        value="{{ optional($formAccesses->firstWhere('position', 'Anggota'))->user->contact ?? '' }}"
                                        class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </td>
            </table>
        </div>

        <div class="h-[85%] w-full font-semibold" x-data="{
            categories: [
                @foreach ($grouped as $index => $category)
                {
                    id: '{{ $index }}',
                    name: '{{ $category->first()->indicator->competency->standard->category->name }}',
                    standards: [
                        @foreach ($category->groupBy('indicator.competency.standard.id') as $standardIndex => $standard)
                        {
                            id: '{{ $standardIndex }}',
                            name: '{{ $standard->first()->indicator->competency->standard->name }}',
                            competencies: [
                                @foreach ($standard->groupBy('indicator.competency.id') as $competencyIndex => $indicators)
                                {
                                    id: '{{ $competencyIndex }}',
                                    statement: '{{ $indicators->first()->indicator->competency->statement }}',
                                    indicators: [
                                        @foreach ($indicators as $indicator)
                                        {
                                            id: '{{ $indicator->id }}',
                                            audit: '{{ $indicator->submission_status }}',
                                            validation: '{{ $indicator->validation }}',
                                            link: '{{ $indicator->link }}',
                                            code: '{{ $indicator->indicator->code }}',
                                            assessment: '{{ $indicator->indicator->assessment }}',
                                            entry: '{{ $indicator->indicator->entry }}',
                                            rate_option: '{{ $indicator->indicator->rate_option }}',
                                            disable_text: '{{ $indicator->indicator->disable_text }}',
                                            info: '{{ $indicator->indicator->info }}',
                                        }, @endforeach
            ]
        },
        @endforeach
        ]
        },
        @endforeach
        ]
        },
        @endforeach
        ],
        openTab: '{{ $grouped->isNotEmpty() ? $grouped->keys()->first() : '' }}',
            isModalOpen: false,
            currentIndicatorId: null,
            trapCleanup: null,
            openModal(indicatorId) {
                this.currentIndicatorId = indicatorId;
                this.isModalOpen = true;
                this.trapCleanup = focusTrap(document.querySelector('#modal-' + indicatorId));
            },
            closeModal() {
                this.isModalOpen = false;
                this.currentIndicatorId = null;
                this.trapCleanup();
            },
            setData(event, indicator) {
                indicator.selectedOption = event.target.value;
            }
        }" x-init="window.Echo.channel('forms').listen('FormUpdated', event => {
            console.log('test');
            console.log(event);
        });">
            <div class="mb-2 flex justify-between gap-x-2">
                <div class="flex w-[70%] whitespace-nowrap" data-simplebar>
                    <ul class="flex">
                        <template x-for="category in categories" :key="category.id">
                            <li @click.prevent="openTab = category.id"
                                :class="openTab === category.id ?
                                    'text-indigo-800 dark:text-purple-400 border border-indigo-800 dark:border-gray-500' :
                                    'border-2 border-gray-200 text-gray-500 dark:text-gray-400 hover:text-green-400 dark:hover:text-gray-200 hover:border hover:border-indigo-800 dark:hover:border-purple-500'"
                                class="mr-1 flex cursor-pointer items-center gap-x-2 rounded bg-white p-1 dark:bg-gray-700">
                                <div x-text="category.name"
                                    class="border-0 border-indigo-800 bg-white p-0 text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400">
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div id="scrollspy-scrollable-parent-2"
                class="shadow-xs h-[90%] w-full overflow-y-auto rounded-b rounded-r border-2 border-gray-200 bg-white px-3 py-1 text-center scrollbar-thin dark:border-gray-500 dark:bg-gray-700 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                <template x-for="category in categories" :key="category.id">
                    <div x-show="openTab === category.id" class="grid grid-cols-7 gap-4">
                        <div class="col-span-1">
                            <ul class="sticky top-0 max-h-[463px] overflow-y-auto scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800"
                                data-hs-scrollspy="#scrollspy-2"
                                data-hs-scrollspy-scrollable-parent="#scrollspy-scrollable-parent-2">
                                <template x-for="standard in category.standards" :key="standard.id">
                                    <li data-hs-scrollspy-group="">
                                        <a :href="'#standard-' + standard.id" x-text="standard.name"
                                            class="active block py-0.5 text-left text-sm font-medium leading-6 text-gray-700 hover:text-gray-900 focus:text-blue-600 focus:outline-none hs-scrollspy-active:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-blue-500 dark:hs-scrollspy-active:text-blue-500"></a>
                                        <template x-for="competency in standard.competencies" :key="competency.id">
                                            <ul>
                                                <template x-for="indicator in competency.indicators"
                                                    :key="indicator.id">
                                                    <li class="ms-6">
                                                        <a x-text="indicator.code" {{-- :href="'#indicator-' + indicator.id" --}}
                                                            class="group flex items-center gap-x-2 py-0.5 text-sm leading-6 text-gray-700 hover:text-gray-800 focus:text-blue-600 focus:outline-none hs-scrollspy-active:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-blue-500 dark:hs-scrollspy-active:text-blue-500">
                                                        </a>
                                                    </li>
                                                </template>
                                            </ul>
                                        </template>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <div class="col-span-6">
                            <div id="scrollspy-2" class="space-y-4">
                                <template x-for="standard in category.standards" :key="standard.id">
                                    <div>
                                        <div class="flex items-center justify-start gap-x-2">
                                            <div x-text="standard.name" :id="'standard-' + standard.id"
                                                class="min-w-52 border-0 border-indigo-800 bg-white pl-2 text-left text-lg font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400"
                                                x-bind:style="'width: ' + (standard.name.length + 1) + 'ch;'"
                                                placeholder="Enter Standard Name"></div>
                                        </div>
                                        <table class="w-full border-collapse">
                                            <thead>
                                                <tr class="text-xs md:text-sm">
                                                    <th
                                                        class="w-[40%] border border-indigo-800 font-semibold dark:border-gray-400 dark:text-white">
                                                        Competencies</th>
                                                    <th
                                                        class="border border-indigo-800 font-semibold dark:border-gray-400 dark:text-white">
                                                        Indicators</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="competency in standard.competencies"
                                                    :key="competency.id">
                                                    <tr>
                                                        <td
                                                            class="border border-blue-800 p-3 dark:border-gray-500 dark:text-white">
                                                            <div x-text="competency.statement"
                                                                style="text-align: justify;"
                                                                class="w-full text-indigo-800">
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="border border-blue-800 p-3 dark:border-gray-500 dark:text-white">
                                                            <template x-for="indicator in competency.indicators"
                                                                :key="indicator.id">
                                                                <div
                                                                    class="mb-4 flex w-full items-center justify-between gap-x-5 gap-y-2 px-2">
                                                                    <div
                                                                        class="flex w-full flex-col items-center justify-between gap-x-4 gap-y-2 md:flex-row">
                                                                        <div x-text="indicator.code"
                                                                            class="border-0 border-indigo-800 bg-transparent text-sm font-semibold text-indigo-800 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400">
                                                                        </div>
                                                                        <div x-text="indicator.assessment"
                                                                            :id="'indicator-' + indicator.id"
                                                                            class="w-full border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent text-sm font-semibold text-indigo-800"
                                                                            style="text-align: justify;">
                                                                        </div>
                                                                        <template x-if="indicator.disable_text">
                                                                            <div class="hs-tooltip [--trigger:hover]">
                                                                                <div
                                                                                    class="hs-tooltip-toggle flex items-center justify-center">
                                                                                    <button type="button"
                                                                                        class="text-gray-500 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                                        <svg class="size-6"
                                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                                            width="24"
                                                                                            height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            fill="none"
                                                                                            stroke="currentColor"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round">
                                                                                            <path
                                                                                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z">
                                                                                            </path>
                                                                                        </svg>
                                                                                    </button>
                                                                                    <div class="hs-tooltip-content invisible absolute z-50 hidden max-w-xs rounded-lg border border-gray-100 bg-white text-start opacity-0 shadow-md transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:border-neutral-700 dark:bg-neutral-800"
                                                                                        role="tooltip">
                                                                                        <span
                                                                                            class="px-4 pt-3 text-lg font-bold text-gray-800 dark:text-white">
                                                                                            Indicator Info</span>
                                                                                        <div
                                                                                            class="flex flex-col gap-2 px-4 py-3 text-sm text-gray-600 dark:text-neutral-400">
                                                                                            <p
                                                                                                x-text="indicator.disable_text">
                                                                                            </p>
                                                                                            <p x-show="!indicator.disable_text"
                                                                                                class="text-base">
                                                                                                No info available
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </template>
                                                                        <!-- Modal Content -->
                                                                        <template
                                                                            x-if="!indicator.audit | !indicator.validation | !indicator.link">
                                                                            <button
                                                                                x-show="
                                                                            ['Option', 'Digit', 'Decimal', 'Cost', 'Percentage', 'Rate'].includes(indicator.entry)"
                                                                                type="button"
                                                                                @click="openModal(indicator.id)"
                                                                                class="text-gray-500 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                                <i class="fas fa-marker"></i>
                                                                            </button>
                                                                        </template>
                                                                        <template
                                                                            x-if="indicator.audit && indicator.validation && indicator.link">
                                                                            <button @click="openModal(indicator.id)"
                                                                                x-show="
                                                                            ['Option', 'Digit', 'Decimal', 'Cost', 'Percentage', 'Rate'].includes(indicator.entry)"
                                                                                type="button"
                                                                                class="text-blue-600 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                                <i class="fa-solid fa-check fa-lg"></i>
                                                                            </button>
                                                                        </template>

                                                                        <!-- Modal backdrop. This what you want to place close to the closing body tag -->
                                                                        <div x-show="isModalOpen && currentIndicatorId === indicator.id"
                                                                            x-transition:enter="transition ease-out duration-150"
                                                                            x-transition:enter-start="opacity-0"
                                                                            x-transition:enter-end="opacity-100"
                                                                            x-transition:leave="transition ease-in duration-150"
                                                                            x-transition:leave-start="opacity-100"
                                                                            x-transition:leave-end="opacity-0"
                                                                            class="fixed inset-0 z-50 flex items-end justify-center bg-black bg-opacity-50 sm:items-center">
                                                                            <!-- Modal -->
                                                                            <div x-show="isModalOpen && currentIndicatorId === indicator.id"
                                                                                x-transition:enter="transition ease-out duration-150"
                                                                                x-transition:enter-start="opacity-0 transform translate-y-1/2"
                                                                                x-transition:enter-end="opacity-100"
                                                                                x-transition:leave="transition ease-in duration-150"
                                                                                x-transition:leave-start="opacity-100"
                                                                                x-transition:leave-end="opacity-0  transform translate-y-1/2"
                                                                                @click.away="closeModal()"
                                                                                @keydown.escape="closeModal()"
                                                                                class="w-full overflow-hidden rounded-t-lg bg-white px-6 py-4 text-left dark:bg-gray-800 sm:m-4 sm:max-w-xl sm:rounded-lg"
                                                                                role="dialog"
                                                                                :id="'modal-' + indicator.id">
                                                                                <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                                                                                <header class="flex justify-end">
                                                                                    <button type="button"
                                                                                        class="inline-flex h-6 w-6 items-center justify-center rounded text-gray-400 transition-colors duration-150 hover:text-gray-700 dark:hover:text-gray-200"
                                                                                        aria-label="close"
                                                                                        @click="closeModal()">
                                                                                        <svg class="h-4 w-4"
                                                                                            fill="currentColor"
                                                                                            viewBox="0 0 20 20"
                                                                                            role="img"
                                                                                            aria-hidden="true">
                                                                                            <path
                                                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                                clip-rule="evenodd"
                                                                                                fill-rule="evenodd">
                                                                                            </path>
                                                                                        </svg>
                                                                                    </button>
                                                                                </header>
                                                                                <!-- Modal body -->

                                                                                <!-- Modal title -->
                                                                                <div
                                                                                    class="mb-4 flex flex-col gap-y-5 text-gray-500">
                                                                                    <h3
                                                                                        class="font-semibold text-indigo-600 dark:text-gray-300">
                                                                                        Set Report for
                                                                                        <span
                                                                                            x-text="indicator.code"></span>
                                                                                        <div class="text-gray-700"
                                                                                            x-text="indicator.assessment">
                                                                                        </div>
                                                                                    </h3>
                                                                                    <div class="flex flex-col gap-y-8">
                                                                                        <div class="text-indigo-600">
                                                                                            Auditee Form
                                                                                        </div>
                                                                                        <!-- Modal form -->
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <svg class="size-6"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                width="24"
                                                                                                height="24"
                                                                                                viewBox="0 0 24 24"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round">
                                                                                                <path
                                                                                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z">
                                                                                                </path>
                                                                                                <path
                                                                                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z">
                                                                                                </path>
                                                                                            </svg>
                                                                                            {{-- Validation --}}
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Option'">
                                                                                                <select
                                                                                                    x-model="indicator.validation"
                                                                                                    :name="'audits[' +
                                                                                                    indicator.id +
                                                                                                        '][validation]'"
                                                                                                    class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-3 py-0 font-semibold text-indigo-800 focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                                    <option hidden
                                                                                                        value="">
                                                                                                        Pilih validasi
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="Yes">
                                                                                                        Ya
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="No">
                                                                                                        Tidak
                                                                                                    </option>
                                                                                                </select>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Digit'">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <input
                                                                                                        x-model="indicator.validation"
                                                                                                        :name="'audits[' +
                                                                                                        indicator.id +
                                                                                                            '][validation]'"
                                                                                                        type="number"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-300 bg-transparent px-3 py-2.5 text-gray-900 placeholder-gray-400 placeholder-transparent focus:border-blue-600 focus:placeholder-gray-400 focus:outline-none focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                                                                                        placeholder="Enter a digit"
                                                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                                                                                    <label
                                                                                                        for="digit"
                                                                                                        class="px-3 absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Digit
                                                                                                    </label>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Decimal'">

                                                                                                <!-- Input Number -->
                                                                                                <div class="rounded-lg w-[90%] border border-gray-200 bg-white px-3 py-2 dark:border-neutral-700 dark:bg-neutral-900"
                                                                                                    data-hs-input-number="">
                                                                                                    <div
                                                                                                        class="flex w-full items-center justify-between gap-x-5">
                                                                                                        <div
                                                                                                            class="grow">
                                                                                                            <span
                                                                                                                class="block text-xs text-gray-500 dark:text-neutral-400">
                                                                                                                Decimal
                                                                                                            </span>
                                                                                                            <input :name="'audits[' +
                                                                                                            indicator.id +
                                                                                                                '][validation]'"
                                                                                                        x-model="indicator.validation"
                                                                                                        class="w-full border-0 bg-transparent p-0 text-gray-800 focus:ring-0 dark:text-white [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                                                                                style="-moz-appearance: textfield;"
                                                                                                                type="number"
                                                                                                                aria-roledescription="Number field"
                                                                                                                value="1"
                                                                                                                max="100"
                                                                                                                step="0.0000000001"
                                                                                                                data-hs-input-number-input=""
                                                                                                                >
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="flex items-center justify-end gap-x-1.5">
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="size-6 inline-flex items-center justify-center gap-x-2 rounded-full border border-gray-200 bg-white text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50 focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                                                                                                tabindex="-1"
                                                                                                                aria-label="Decrease"
                                                                                                                data-hs-input-number-decrement="">
                                                                                                                <svg class="size-3.5 shrink-0"
                                                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                                                    width="24"
                                                                                                                    height="24"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    fill="none"
                                                                                                                    stroke="currentColor"
                                                                                                                    stroke-width="2"
                                                                                                                    stroke-linecap="round"
                                                                                                                    stroke-linejoin="round">
                                                                                                                    <path
                                                                                                                        d="M5 12h14">
                                                                                                                    </path>
                                                                                                                </svg>
                                                                                                            </button>
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="size-6 inline-flex items-center justify-center gap-x-2 rounded-full border border-gray-200 bg-white text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50 focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                                                                                                tabindex="-1"
                                                                                                                aria-label="Increase"
                                                                                                                data-hs-input-number-increment="">
                                                                                                                <svg class="size-3.5 shrink-0"
                                                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                                                    width="24"
                                                                                                                    height="24"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    fill="none"
                                                                                                                    stroke="currentColor"
                                                                                                                    stroke-width="2"
                                                                                                                    stroke-linecap="round"
                                                                                                                    stroke-linejoin="round">
                                                                                                                    <path
                                                                                                                        d="M5 12h14">
                                                                                                                    </path>
                                                                                                                    <path
                                                                                                                        d="M12 5v14">
                                                                                                                    </path>
                                                                                                                </svg>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <!-- End Input Number -->

                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Cost'">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <input
                                                                                                        x-model="indicator.validation"
                                                                                                        :name="'audits[' +
                                                                                                        indicator.id +
                                                                                                            '][validation]'"
                                                                                                        id="price"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-300 bg-transparent px-3 py-2.5 text-gray-900 placeholder-gray-400 placeholder-transparent focus:border-blue-600 focus:placeholder-gray-400 focus:outline-none focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                                                                                        placeholder="Rupiah"
                                                                                                        type-currency="IDR" />
                                                                                                    <label
                                                                                                        for="price"
                                                                                                        class="px-3 absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Rupiah
                                                                                                    </label>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Percentage'">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <input
                                                                                                        x-model="indicator.validation"
                                                                                                        oninput="if(this.value > 100) this.value = 100; if(this.value < 0) this.value = 0; this.value = this.value.replace(/[^0-9]/g, '')"
                                                                                                        :name="'audits[' +
                                                                                                        indicator.id +
                                                                                                            '][validation]'"
                                                                                                        max="100"
                                                                                                        type="number"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-300 bg-transparent px-3  py-2.5  text-gray-900 placeholder-gray-400 placeholder-transparent focus:border-blue-600 focus:placeholder-gray-400 focus:outline-none focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                                                                                        placeholder="Enter percentage %" />
                                                                                                    <label
                                                                                                        for="percentage"
                                                                                                        class="px-3 absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Percentage
                                                                                                    </label>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Rate' && (indicator.rate_option === null || indicator.rate_option === '' || indicator.rate_option === '1-10')">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <label
                                                                                                        for="percentage">
                                                                                                        Rate 1 - 10
                                                                                                    </label>
                                                                                                    <input
                                                                                                        id="Rate_1-10"
                                                                                                        x-model="indicator.validation"
                                                                                                        class="w-full"
                                                                                                        :name="'audits[' +
                                                                                                        indicator.id +
                                                                                                            '][validation]'"
                                                                                                        value="0"
                                                                                                        type="range"
                                                                                                        min="0"
                                                                                                        max="10"
                                                                                                        step="1" />
                                                                                                    <div
                                                                                                        class="flex w-full justify-between px-2 text-xs">
                                                                                                        @for ($i = 0; $i <= 10; $i++)
                                                                                                            <span>{{ $i }}</span>
                                                                                                        @endfor
                                                                                                    </div>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Rate' && indicator.rate_option === '1-100'">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <input
                                                                                                        x-model="indicator.validation"
                                                                                                        oninput="if(this.value > 100) this.value = 100; if(this.value < 0) this.value = 0; this.value = this.value.replace(/[^0-9]/g, '')"
                                                                                                        :name="'audits[' +
                                                                                                        indicator.id +
                                                                                                            '][validation]'"
                                                                                                        max="100"
                                                                                                        type="number"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-300 bg-transparent px-3  py-2.5  text-gray-900 placeholder-gray-400 placeholder-transparent focus:border-blue-600 focus:placeholder-gray-400 focus:outline-none focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500"
                                                                                                        placeholder="Range 1 - 100" />
                                                                                                    <label
                                                                                                        for="Rate"
                                                                                                        class="px-3 absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Rate
                                                                                                    </label>
                                                                                                </div>
                                                                                            </template>
                                                                                            {{-- End Validation --}}
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex items-center justify-end gap-x-3">
                                                                                            <input type="hidden"
                                                                                                x-model="indicator.id"
                                                                                                :name="'audits[' +
                                                                                                indicator.id + '][id]'">
                                                                                            <select
                                                                                                x-model="indicator.audit"
                                                                                                :name="'audits[' +
                                                                                                indicator.id +
                                                                                                    '][status]'"
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent py-0 font-semibold text-indigo-800 focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                                <option hidden
                                                                                                    value="">
                                                                                                    Pilih Capaian Standar
                                                                                                </option>
                                                                                                @foreach ($statuses as $status)
                                                                                                    <option
                                                                                                        value="{{ $status->id }}"
                                                                                                        {{-- {{ $indicator->audit_status == $status->id ? 'selected' : '' }} --}}>
                                                                                                        {{ $status->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <div
                                                                                                class="hs-tooltip items-center justify-center [--trigger:hover] md:flex">
                                                                                                <div
                                                                                                    class="hs-tooltip-toggle">
                                                                                                    <button
                                                                                                        type="button"
                                                                                                        class="align-middle text-gray-500 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                                                        <svg class="size-6"
                                                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                                                            width="24"
                                                                                                            height="24"
                                                                                                            viewBox="0 0 24 24"
                                                                                                            fill="none"
                                                                                                            stroke="currentColor"
                                                                                                            stroke-width="2"
                                                                                                            stroke-linecap="round"
                                                                                                            stroke-linejoin="round">
                                                                                                            <path
                                                                                                                stroke-linecap="round"
                                                                                                                stroke-linejoin="round"
                                                                                                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z">
                                                                                                            </path>
                                                                                                        </svg>
                                                                                                    </button>
                                                                                                    <div class="hs-tooltip-content invisible absolute z-50 hidden max-w-xs rounded-lg border border-gray-100 bg-white text-start opacity-0 shadow-md transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:border-neutral-700 dark:bg-neutral-800"
                                                                                                        role="tooltip">
                                                                                                        <span
                                                                                                            class="px-4 pt-3 text-lg font-bold text-gray-800 dark:text-white">
                                                                                                            Link
                                                                                                            Verification
                                                                                                            Info</span>
                                                                                                        <div
                                                                                                            class="flex flex-col gap-2 px-4 py-3 text-sm text-gray-600 dark:text-neutral-400">
                                                                                                            <p class="md:hidden"
                                                                                                                x-text="indicator.entry">
                                                                                                            </p>
                                                                                                            <p
                                                                                                                x-text="indicator.info">
                                                                                                            </p>
                                                                                                            <p x-show="!indicator.info"
                                                                                                                class="text-base">
                                                                                                                No info
                                                                                                                available
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="flex w-[90%] rounded-lg shadow-sm">
                                                                                                <div
                                                                                                    class="inline-flex min-w-fit items-center rounded-s-md border border-e-0 border-gray-200 bg-gray-50 px-4 dark:border-neutral-600 dark:bg-neutral-700">
                                                                                                    <span
                                                                                                        class="text-sm text-gray-500 dark:text-neutral-400">Link</span>
                                                                                                </div>
                                                                                                <input type="text"
                                                                                                    x-model="indicator.link"
                                                                                                    :name="'audits[' +
                                                                                                    indicator.id +
                                                                                                        '][link]'"
                                                                                                    id="hs-input-with-add-on-url"
                                                                                                    class="block w-full rounded-e-lg border-gray-200 px-4 py-3 pe-11 text-sm shadow-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                                                                                    placeholder="https://www.example.com">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <footer
                                                                                        class="-mx-6 -mb-4 flex flex-row items-center justify-end space-x-6 space-y-0 bg-gray-50 px-6 py-3 dark:bg-gray-800">
                                                                                        <button type="button"
                                                                                            @click="closeModal()"
                                                                                            class="text w-full rounded-lg border border-transparent bg-indigo-600 px-5 py-3 text-sm font-semibold leading-5 text-white transition-colors duration-150 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple active:bg-purple-600 sm:w-auto sm:px-4 sm:py-2">
                                                                                            Save
                                                                                        </button>
                                                                                    </footer>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- End of modal backdrop -->
                                                                        <!-- End Modal Content -->
                                                                        {{-- </div> --}}
                                                                    </div>
                                                            </template>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </div>

        <div class="mt-2 space-x-10 text-right">
            <button type="submit" name="action" value="draft"
                class="inline-flex rounded-md bg-gray-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-600">
                {{ __('Save as a Draft') }}
            </button>
            @if ($userAccesses->contains('position', 'Pimpinan'))
                <button type="submit" name="action" value="submit"
                    class="inline-flex rounded-md bg-blue-700 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-800">
                    {{ __('Submit') }}
                </button>
            @endif
        </div>
    </form>

</x-app-layout>
