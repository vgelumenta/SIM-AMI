<x-app-layout>
    <div x-data="form()" class="flex h-full w-full flex-col gap-y-1 font-semibold">

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
            </ol>
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
                    x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
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

        <div class="flex h-[85%] w-full flex-col gap-y-2 overflow-auto">

            <div class="flex justify-between gap-x-2">
                <div class="flex w-full whitespace-nowrap" data-simplebar>
                    <ul class="flex">
                        <template x-for="category in categories" :key="category.id">
                            <li @click.prevent="openTab = category.id" x-text="category.name"
                                :class="openTab === category.id ?
                                    'border border-indigo-800 dark:text-cool-gray-50 text-indigo-800 dark:border-cool-gray-50' :
                                    'border-2 border-gray-300 text-gray-500 hover:border hover:text-green-400 hover:border-green-400 dark:hover:border-red-500 dark:hover:text-gray-200 dark:border-gray-400 dark:text-gray-400'"
                                class="mr-1 flex cursor-pointer items-center gap-x-2 rounded bg-white p-1 dark:bg-gray-700">
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div id="scrollspy-scrollable-parent-2"
                class="shadow-xs h-[90%] w-full overflow-y-auto rounded border-2 border-gray-200 bg-white px-2 text-center scrollbar-thin dark:border-gray-300 dark:bg-gray-700 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                <template x-for="category in categories" :key="category.id">
                    <div x-show="openTab === category.id, initTextareas()" class="grid grid-cols-7 gap-4">
                        <div class="col-span-1">
                            <ul class="sticky top-0 max-h-[463px] overflow-y-auto scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800"
                                data-hs-scrollspy="#scrollspy-2"
                                data-hs-scrollspy-scrollable-parent="#scrollspy-scrollable-parent-2">
                                <template x-for="standard in category.standards" :key="standard.id">
                                    <li data-hs-scrollspy-group="">
                                        <a :href="'#standard-' + standard.id" x-text="standard.name"
                                            class="ms-2 hidden py-1 text-left text-sm leading-6 text-gray-700 hover:text-gray-900 focus:text-blue-600 focus:outline-none hs-scrollspy-active:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-blue-500 dark:hs-scrollspy-active:text-blue-500 md:block"></a>
                                        <template x-for="competency in standard.competencies" :key="competency.id">
                                            <ul>
                                                <template x-for="indicator in competency.indicators"
                                                    :key="indicator.id">
                                                    <li class="xl:ms-6">
                                                        <a x-text="indicator.code" :href="'#standard-' + standard.id"
                                                            class="group flex items-center gap-x-2 text-sm leading-6 text-gray-700 hover:text-gray-800 focus:text-blue-600 focus:outline-none hs-scrollspy-active:text-blue-600 dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-blue-500 dark:hs-scrollspy-active:text-blue-500">
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
                            <div class="flex flex-col gap-y-5 py-2">
                                <template x-for="standard in category.standards" :key="standard.id">
                                    <div>
                                        <div x-text="standard.name" :id="'standard-' + standard.id"
                                            class="bg-white px-2 text-left text-indigo-700 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400 sm:text-lg">
                                        </div>
                                        <table class="w-full border-collapse">
                                            <thead>
                                                <tr class="bg-indigo-700 text-xs text-white md:text-sm">
                                                    <th
                                                        class="w-[40%] border border-indigo-800 dark:border-gray-400 dark:text-white">
                                                        Competencies</th>
                                                    <th
                                                        class="border border-indigo-800 dark:border-gray-400 dark:text-white">
                                                        Indicators</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="competency in standard.competencies"
                                                    :key="competency.id">
                                                    <tr>
                                                        <td
                                                            class="border border-blue-800 p-3 dark:border-gray-500 dark:text-white">
                                                            <textarea x-model="competency.statement" disabled
                                                                class="w-full resize-none overflow-hidden border-0 bg-transparent p-0 text-indigo-700 focus:ring-0"
                                                                style="text-align: justify;" placeholder="Competency Statement">
                                                            </textarea>
                                                        </td>
                                                        <td
                                                            class="border border-blue-800 px-4 py-1 dark:border-gray-500 dark:text-white">
                                                            <template x-for="indicator in competency.indicators"
                                                                :key="indicator.id">
                                                                <div
                                                                    class="my-4 flex w-full flex-col items-center justify-end gap-x-4 gap-y-1 md:flex-row">
                                                                    <div x-text="indicator.code"
                                                                        class="text-sm text-indigo-700 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400">
                                                                    </div>
                                                                    <div class="flex w-full flex-col gap-y-1">
                                                                        <div x-text="indicator.assessment"
                                                                            class="line-clamp-3 w-full border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent text-sm text-indigo-700"
                                                                            style="text-align: justify;">
                                                                        </div>
                                                                        <div class="flex items-center gap-x-3">
                                                                            <template
                                                                                x-if="parseInt(indicator.submission_status) < parseInt(indicator.assessment_status)">
                                                                                <div
                                                                                    class="text-green-400 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <svg class="size-5"
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round">
                                                                                        <path
                                                                                            d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18">
                                                                                        </path>
                                                                                    </svg>
                                                                                </div>
                                                                            </template>
                                                                            <template
                                                                                x-if="parseInt(indicator.submission_status) === parseInt(indicator.assessment_status)">
                                                                                <div
                                                                                    class="text-yellow-300 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <svg class="size-6"
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round">
                                                                                        <path
                                                                                            d="M3.75 9h16.5m-16.5 6.75h16.5">
                                                                                        </path>
                                                                                    </svg>
                                                                                </div>
                                                                            </template>
                                                                            <template
                                                                                x-if="parseInt(indicator.submission_status) > parseInt(indicator.assessment_status)">
                                                                                <div
                                                                                    class="text-red-500 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <svg class="size-5"
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round">
                                                                                        <path
                                                                                            d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3">
                                                                                        </path>
                                                                                    </svg>
                                                                                </div>
                                                                            </template>
                                                                            <template x-if="indicator.feedback == '0'">
                                                                                <div
                                                                                    class="text-red-500 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <i class="fas fa-user-times"></i>
                                                                                </div>
                                                                            </template>
                                                                            <template x-if="indicator.feedback == '1'">
                                                                                <div
                                                                                    class="text-green-400 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <i class="fas fa-user-check"></i>
                                                                                </div>
                                                                            </template>
                                                                            <template
                                                                                x-if="indicator.verification_status == 1">
                                                                                <div
                                                                                    class="text-red-500 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <i class="fa-solid fa-d"></i>
                                                                                </div>
                                                                            </template>
                                                                            <template
                                                                                x-if="indicator.verification_status == 2">
                                                                                <div
                                                                                    class="text-yellow-300 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <i class="fa-solid fa-c"></i>
                                                                                </div>
                                                                            </template>
                                                                            <template
                                                                                x-if="indicator.verification_status == 3">
                                                                                <div
                                                                                    class="text-green-400 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <i class="fa-solid fa-b"></i>
                                                                                </div>
                                                                            </template>
                                                                            <template
                                                                                x-if="indicator.verification_status == 4">
                                                                                <div
                                                                                    class="text-blue-500 dark:text-neutral-500 dark:focus:text-blue-500">
                                                                                    <i class="fa-solid fa-a"></i>
                                                                                </div>
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                    <template x-if="indicator.entry == 'Disable'">
                                                                        <div x-show="indicator.disable_text"
                                                                            class="hs-tooltip">
                                                                            <svg class="size-6 hs-tooltip-toggle cursor-pointer text-gray-500 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path
                                                                                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z">
                                                                                </path>
                                                                            </svg>
                                                                            <div style="text-align: justify;"
                                                                                class="hs-tooltip-content invisible absolute z-10 hidden max-w-xs rounded-lg border border-gray-100 bg-white p-3 text-gray-600 opacity-0 shadow-md transition-opacity hs-tooltip-shown:visible hs-tooltip-shown:opacity-100 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">
                                                                                <h3 class="font-bold text-indigo-600">
                                                                                    Indicator Info</h3>
                                                                                <p class="text-sm"
                                                                                    x-text="indicator.disable_text">
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </template>
                                                                    <!-- Modal Content -->
                                                                    <button @click="openIndicator(indicator.id)"
                                                                        x-show="
                                                                            ['Option', 'Digit', 'Decimal', 'Cost', 'Percentage', 'Rate'].includes(indicator.entry)"
                                                                        type="button"
                                                                        class="text-blue-600 hover:text-blue-700 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                        <i class="fa-solid fa-eye"></i>
                                                                    </button>
                                                                    <div x-show="focusIndicatorId === indicator.id"
                                                                        class="fixed inset-0 z-40 flex items-end justify-center bg-black bg-opacity-50 sm:items-center">
                                                                        <div x-show="focusIndicatorId === indicator.id"
                                                                            @keydown.escape="closeIndicator()"
                                                                            x-transition:enter="transition ease-out duration-150"
                                                                            x-transition:enter-start="opacity-0 transform translate-y-1/2"
                                                                            x-transition:enter-end="opacity-100"
                                                                            x-transition:leave="transition ease-in duration-150"
                                                                            x-transition:leave-start="opacity-100"
                                                                            x-transition:leave-end="opacity-0 transform translate-y-1/2"
                                                                            class="flex w-full max-w-7xl flex-col gap-2 overflow-hidden rounded-t-lg bg-white p-4 dark:bg-gray-800 sm:rounded-lg"
                                                                            :id="'modal-' + indicator.id">
                                                                            <header class="flex justify-between">
                                                                                <h3
                                                                                    class="space-y-2 px-4 text-indigo-600 dark:text-gray-300">
                                                                                    Audit of
                                                                                    <span
                                                                                        x-text="indicator.code"></span>
                                                                                </h3>
                                                                                <button type="button"
                                                                                    class="-mx-1 inline-flex h-6 w-6 items-center justify-center rounded text-gray-500 transition-colors duration-150 hover:text-gray-700 dark:hover:text-gray-200"
                                                                                    @click="closeIndicator()">
                                                                                    <svg class="h-4 w-4"
                                                                                        fill="currentColor"
                                                                                        viewBox="0 0 20 20">
                                                                                        <path
                                                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                            clip-rule="evenodd"
                                                                                            fill-rule="evenodd">
                                                                                        </path>
                                                                                    </svg>
                                                                                </button>
                                                                            </header>
                                                                            <div class="overflow-y-auto px-4 text-gray-700 scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800"
                                                                                style="text-align: justify; max-height: 5rem;"
                                                                                x-text="indicator.assessment">
                                                                            </div>
                                                                            <!-- Modal body -->
                                                                            <div
                                                                                class="flex max-h-[55vh] w-full flex-col gap-8 overflow-y-auto px-4 scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800 md:flex-row">
                                                                                <!-- Submission Form -->
                                                                                <div
                                                                                    class="{{ $form->stage_id == 1 ? 'text-indigo-600' : 'text-gray-500' }} flex w-full flex-col gap-2 text-left">
                                                                                    Submission Form
                                                                                    <!-- Modal form -->
                                                                                    <div class="space-y-6">
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <svg class="size-6 w-6"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2">
                                                                                                <path
                                                                                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z">
                                                                                                </path>
                                                                                            </svg>
                                                                                            <select
                                                                                                x-model="indicator.submission_status"
                                                                                                disabled
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                                <option hidden
                                                                                                    value="">
                                                                                                    Indicator Grade
                                                                                                </option>
                                                                                                @foreach ($statuses as $status)
                                                                                                    <option
                                                                                                        value="{{ $status->id }}">
                                                                                                        {{ $status->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <i
                                                                                                class="fa-solid fa-chart-column fa-lg w-6"></i>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Option'">
                                                                                                <select disabled
                                                                                                    x-model="indicator.validation"
                                                                                                    class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                                    <option hidden
                                                                                                        value="">
                                                                                                        Validation
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="Yes">
                                                                                                        Yes
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="No">
                                                                                                        No
                                                                                                    </option>
                                                                                                </select>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Digit'">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <input disabled
                                                                                                        x-model="indicator.validation"
                                                                                                        placeholder="Digit"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-200 bg-transparent px-4 py-2.5 placeholder-transparent focus:border-indigo-600 focus:placeholder-gray-400 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />
                                                                                                    <div
                                                                                                        class="absolute top-2.5 -z-10 origin-[0] -translate-y-6 scale-75 transform px-4 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Digit
                                                                                                    </div>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Decimal'">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <input disabled
                                                                                                        x-model="indicator.validation"
                                                                                                        placeholder="Decimal"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-200 bg-transparent px-4 py-2.5 placeholder-transparent focus:border-indigo-600 focus:placeholder-gray-400 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />
                                                                                                    <div
                                                                                                        class="absolute top-2.5 -z-10 origin-[0] -translate-y-6 scale-75 transform px-4 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Decimal
                                                                                                    </div>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Cost'">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <input disabled
                                                                                                        x-model="indicator.validation"
                                                                                                        placeholder="Rupiah"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-200 bg-transparent px-4 py-2.5 placeholder-transparent focus:border-indigo-600 focus:placeholder-gray-400 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500" />
                                                                                                    <div
                                                                                                        class="absolute top-2.5 -z-10 origin-[0] -translate-y-6 scale-75 transform px-4 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Rupiah
                                                                                                    </div>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Percentage'">
                                                                                                <div
                                                                                                    class="group relative z-0 flex w-[90%] items-center gap-x-1">
                                                                                                    <input disabled
                                                                                                        x-model="indicator.validation"
                                                                                                        placeholder="Percentage"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-200 bg-transparent px-4 py-2.5 placeholder-transparent focus:border-indigo-600 focus:placeholder-gray-400 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />
                                                                                                    <div
                                                                                                        class="absolute top-2.5 -z-10 origin-[0] -translate-y-6 scale-75 transform px-4 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Percentage
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="px-3 text-lg font-bold text-gray-500">
                                                                                                        %</div>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Rate' && (indicator.rate_option === null || indicator.rate_option === '' || indicator.rate_option === '1-10')">
                                                                                                <div
                                                                                                    class="group relative z-0 w-[90%]">
                                                                                                    <div
                                                                                                        class="px-4 text-sm">
                                                                                                        Rate 1 - 10
                                                                                                    </div>
                                                                                                    <input disabled
                                                                                                        x-model="indicator.validation"
                                                                                                        type="range"
                                                                                                        max="10"
                                                                                                        class="w-full" />
                                                                                                    <div
                                                                                                        class="flex w-full justify-between px-1.5 text-xs">
                                                                                                        @for ($i = 0; $i <= 10; $i++)
                                                                                                            <span>{{ $i }}</span>
                                                                                                        @endfor
                                                                                                    </div>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                x-if="indicator.entry === 'Rate' && indicator.rate_option === '1-100'">
                                                                                                <div
                                                                                                    class="group relative z-0 flex w-[90%] items-center gap-x-1">
                                                                                                    <input disabled
                                                                                                        x-model="indicator.validation"
                                                                                                        placeholder="Range 1 - 100"
                                                                                                        class="peer block w-full appearance-none border-0 border-b-2 border-gray-200 bg-transparent p-3 placeholder-transparent focus:border-indigo-600 focus:placeholder-gray-400 focus:ring-0 dark:border-gray-600 dark:text-white dark:focus:border-blue-500 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />
                                                                                                    <div
                                                                                                        class="absolute top-2.5 -z-10 origin-[0] -translate-y-6 scale-75 transform px-3 text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:text-blue-600 rtl:peer-focus:translate-x-1/4 dark:text-gray-400 peer-focus:dark:text-blue-500">
                                                                                                        Rate
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="text-gray-500">
                                                                                                        /100</div>
                                                                                                </div>
                                                                                            </template>
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <svg class="size-6 w-6"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2">
                                                                                                <path
                                                                                                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244">
                                                                                                </path>
                                                                                            </svg>
                                                                                            <div class="flex w-[90%]">
                                                                                                <div
                                                                                                    class="flex w-full text-sm text-gray-500">
                                                                                                    <div
                                                                                                        class="inline-flex min-w-fit rounded-s-lg border border-e-0 border-gray-200 bg-gray-50 px-4 py-3 text-gray-500 dark:border-neutral-600 dark:bg-neutral-700 dark:text-neutral-400">
                                                                                                        Link
                                                                                                    </div>
                                                                                                    <a :href="indicator.link"
                                                                                                        target="_blank"
                                                                                                        class="inline-flex w-full items-center rounded-e-lg border border-gray-200 bg-gray-50 px-4">
                                                                                                        <span
                                                                                                            x-text="indicator.link"
                                                                                                            class="w-40 truncate hover:text-blue-600 dark:text-neutral-400">
                                                                                                        </span>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End Submission Form -->

                                                                                <!-- Assessment Form -->
                                                                                <div
                                                                                    class="{{ $form->stage_id == 2 ? 'text-indigo-600' : 'text-gray-500' }} flex w-full flex-col gap-y-2 text-left">
                                                                                    Assessment Form
                                                                                    <!-- Modal form -->
                                                                                    <div class="space-y-6">
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <svg class="size-6 w-6"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2">
                                                                                                <path
                                                                                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z">
                                                                                                </path>
                                                                                            </svg>
                                                                                            <select disabled
                                                                                                x-model="indicator.assessment_status"
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                                <option hidden
                                                                                                    value="">
                                                                                                    Indicator Grade
                                                                                                </option>
                                                                                                @foreach ($statuses as $status)
                                                                                                    <option
                                                                                                        value="{{ $status->id }}">
                                                                                                        {{ $status->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <i
                                                                                                class="fa-regular fa-comment-dots fa-lg w-6"></i>
                                                                                            <textarea disabled x-model="indicator.description"
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-4 font-semibold scrollbar-thin focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800"
                                                                                                style="text-align: justify" placeholder="Auditor comments">
                                                                                            </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End Assessment Form -->

                                                                                <!-- Feedback Form -->
                                                                                <div
                                                                                    class="{{ $form->stage_id == 3 ? 'text-indigo-600' : 'text-gray-500' }} flex w-full flex-col gap-y-2 text-left">
                                                                                    Feedback Form
                                                                                    <!-- Modal form -->
                                                                                    <div class="space-y-6">
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <i
                                                                                                class="far fa-handshake fa-lg w-6"></i>
                                                                                            <select disabled
                                                                                                x-model="indicator.feedback"
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                                <option hidden
                                                                                                    value="">
                                                                                                    Feedback Auditee
                                                                                                </option>
                                                                                                <option value="1">
                                                                                                    Agree</option>
                                                                                                <option value="0">
                                                                                                    Disagree
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <i
                                                                                                class="fa-regular fa-comment-dots fa-lg w-6"></i>
                                                                                            <textarea disabled x-model="indicator.comment"
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-4 font-semibold scrollbar-thin focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800"
                                                                                                style="text-align: justify" placeholder="Auditee comments">
                                                                                            </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End Feedback Form -->

                                                                                <!-- Verification Form -->
                                                                                <div
                                                                                    class="{{ $form->stage_id == 4 ? 'text-indigo-600' : 'text-gray-500' }} flex w-full flex-col gap-y-2 text-left">
                                                                                    Verification Form
                                                                                    <!-- Modal form -->
                                                                                    <div class="space-y-6">
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <svg class="size-6 w-6"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2">
                                                                                                <path
                                                                                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z">
                                                                                                </path>
                                                                                            </svg>
                                                                                            <select disabled
                                                                                                x-model="indicator.verification_status"
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                                <option hidden
                                                                                                    value="">
                                                                                                    Indicator Grade
                                                                                                </option>
                                                                                                @foreach ($statuses as $status)
                                                                                                    <option
                                                                                                        value="{{ $status->id }}">
                                                                                                        {{ $status->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex items-center justify-between gap-x-3">
                                                                                            <svg class="size-6 w-6"
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                stroke-width="2">
                                                                                                <path
                                                                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                                                                                                </path>
                                                                                            </svg>
                                                                                            <textarea disabled x-model="indicator.conclusion"
                                                                                                class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-4 font-semibold scrollbar-thin focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800"
                                                                                                style="text-align: justify" placeholder="Enter final conclusion">
                                                                                        </textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End Verification Form -->
                                                                            </div>
                                                                            <!-- End Modal body -->
                                                                            <footer
                                                                                class="-mx-6 flex flex-row items-center justify-end px-6 pt-2 dark:bg-gray-800">
                                                                                <button @click="closeIndicator()"
                                                                                    type="button"
                                                                                    class="w-full rounded-lg bg-indigo-600 px-5 py-3 text-sm text-white transition-colors duration-150 hover:bg-blue-800 focus:shadow-outline-indigo sm:w-auto sm:px-4 sm:py-2">
                                                                                    Close
                                                                                </button>
                                                                            </footer>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End of modal backdrop -->
                                                                    <!-- End Modal Content -->
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

        <div class="flex justify-between">
            <a href="/forms"
                class="rounded-md bg-gray-500 px-4 py-2 text-xs uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-600 focus:shadow-outline-gray">
                {{ __('Back') }}
            </a>
        </div>
    </div>

    <script>
        function form() {
            return {
                categories: [
                    @foreach ($grouped as $index => $category)
                        {
                            id: '{{ $index }}',
                            name: @json($category->first()->indicator->competency->standard->category->name),
                            standards: [
                                @foreach ($category->groupBy('indicator.competency.standard.id') as $standardIndex => $standard)
                                    {
                                        id: '{{ $standardIndex }}',
                                        name: @json($standard->first()->indicator->competency->standard->name),
                                        competencies: [
                                            @foreach ($standard->groupBy('indicator.competency.id') as $competencyIndex => $indicators)
                                                {
                                                    id: '{{ $competencyIndex }}',
                                                    statement: @json($indicators->first()->indicator->competency->statement),
                                                    indicators: [
                                                        @foreach ($indicators as $indicator)
                                                            {
                                                                id: '{{ $indicator->id }}',
                                                                submission_status: '{{ $indicator->submission_status }}',
                                                                validation: '{{ $indicator->validation }}',
                                                                link: '{{ $indicator->link }}',
                                                                assessment_status: '{{ $indicator->assessment_status }}',
                                                                description: @json($indicator->description),
                                                                feedback: '{{ $indicator->feedback }}',
                                                                comment: @json($indicator->comment),
                                                                verification_status: '{{ $indicator->verification_status }}',
                                                                conclusion: @json($indicator->conclusion),
                                                                code: '{{ $indicator->indicator->code }}',
                                                                assessment: @json($indicator->indicator->assessment),
                                                                entry: '{{ $indicator->indicator->entry }}',
                                                                rate_option: '{{ $indicator->indicator->rate_option }}',
                                                                disable_text: @json($indicator->indicator->disable_text),
                                                            },
                                                        @endforeach
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
                initTextareas() {
                    function textareaAutoHeight(el, offsetTop = 0) {
                        el.style.height = 'auto';
                        el.style.height = `${el.scrollHeight + offsetTop}px`;
                    }

                    this.$nextTick(() => {
                        document.querySelectorAll('textarea').forEach(textarea => {
                            textarea.addEventListener('focus', () => textareaAutoHeight(textarea, 30));
                            textareaAutoHeight(textarea, 30); // Initial call
                        });
                    });

                },
                isContactOpen: false,
                openContact() {
                    this.isContactOpen = true;
                    this.focusTrap = focusTrap(document.querySelector('#modal-contact'));
                },
                closeContact() {
                    this.isContactOpen = false
                    this.focusTrap();
                },
                focusIndicatorId: null,
                focusTrap: null,
                openIndicator(indicatorId) {
                    this.focusIndicatorId = indicatorId;
                    this.focusTrap = focusTrap(document.querySelector('#modal-' + indicatorId));
                },
                closeIndicator() {
                    // Close without confirmation if no changes
                    this.focusIndicatorId = null;
                    this.focusTrap();
                },
            }
        }
    </script>

</x-app-layout>
