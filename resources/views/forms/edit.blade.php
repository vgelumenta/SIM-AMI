<x-app-layout>
    <div class="flex h-full w-full flex-col">

        <div class="flex items-center justify-between font-semibold text-blue-800 dark:text-cool-gray-50 sm:text-lg">
            <ol class="flex items-center gap-x-2">
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
                <li>
                    <input type="text" value="{{ $form->unit->name }}"
                        style="width: calc({{ strlen($form->unit->name) }}ch - 1ch);" readonly
                        class="border-0 border-indigo-800 bg-transparent p-0 text-lg font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400" />
                </li>
                <li>
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li>
                    <input type="text" value="{{ $form->document->name }}" readonly
                        class="border-0 border-indigo-800 bg-transparent p-0 text-lg font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400" />
                </li>
            </ol>
            <div class="flex items-center gap-x-2">
                @if ($errors->any())
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
                @endif
            </div>
        </div>

        <!-- Stepper -->
        <div class="h-[85%] w-full" data-hs-stepper="">
            <!-- Stepper Nav -->
            <ul class="mx-auto flex w-2/3 gap-x-2">
                <!-- First Item -->
                <li class="group flex flex-1 shrink basis-0 items-center gap-x-2"
                    data-hs-stepper-nav-item='{ "index": 1}'>
                    <span class="min-w-7 min-h-7 group inline-flex items-center align-middle text-xs">
                        <span
                            class="size-7 flex shrink-0 items-center justify-center rounded-full bg-white font-medium text-gray-800 group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600">
                            <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">
                                1
                            </span>
                            <svg class="size-3 hidden shrink-0 hs-stepper-success:block"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-cool-gray-50">
                            Identity
                        </span>
                    </span>
                    <div
                        class="h-px w-full flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600">
                    </div>
                </li>
                <!-- End First Item -->
                <!-- Second Item -->
                <li class="group flex flex-1 shrink basis-0 items-center gap-x-2"
                    data-hs-stepper-nav-item='{"index": 2}'>
                    <span class="min-w-7 min-h-7 group inline-flex items-center align-middle text-xs">
                        <span
                            class="size-7 flex shrink-0 items-center justify-center rounded-full bg-white font-medium text-gray-800 group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600">
                            <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">
                                2
                            </span>
                            <svg class="size-3 hidden shrink-0 hs-stepper-success:block"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-cool-gray-50">
                            Access
                        </span>
                    </span>
                    <div
                        class="h-px w-full flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600">
                    </div>
                </li>
                <!-- End Second Item -->
                <!-- Third Item -->
                <li class="group flex flex-1 shrink basis-0 items-center gap-x-2"
                    data-hs-stepper-nav-item='{"index": 3}'>
                    <span class="min-w-7 min-h-7 group inline-flex items-center align-middle text-xs">
                        <span
                            class="size-7 flex shrink-0 items-center justify-center rounded-full bg-white font-medium text-gray-800 group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600">
                            <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">
                                3
                            </span>
                            <svg class="size-3 hidden shrink-0 hs-stepper-success:block"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </span>
                        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-cool-gray-50">
                            Forms
                        </span>
                    </span>
                    <div
                        class="h-px w-full flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600">
                    </div>
                </li>
                <!-- End Third Item -->
            </ul>
            <!-- End Stepper Nav -->

            <!-- Stepper Content -->
            <form action="/forms/{{ $form->id }}" method="POST" class="mt-2 h-full w-full">
                @csrf
                @method('PUT')

                <div x-data="script()"
                    class="flex h-[92%] w-full flex-col items-center justify-center overflow-y-auto rounded-sm border border-dashed border-gray-200 bg-gray-50 scrollbar-thin dark:border-neutral-700 dark:bg-neutral-800 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                    <!-- First Content -->
                    <div class="h-full w-full" data-hs-stepper-content-item='{"index": 1}'>
                        <div class="mx-auto my-10 grid w-1/4 grid-cols-1 gap-4 text-sm">
                            <header class="text-center">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ __($form->unit->name) }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                    {{ __('Tentukan Unit Deadline, Auditor, dan Unit Kerja.') }}
                                </p>
                            </header>

                            {{-- <div class="flex flex-col gap-2">
                                <x-input-label for="name" :value="__('Pilih Auditee')" />
                                <select id="hs-select-with-multiple-setter" multiple="" x-model="selectedOptions"
                                    name="units[]" @change="updateSelectedUnits()"
                                    data-hs-select='{
                                    "hasSearch": true,
                                    "placeholder": "Select multiple options...",
                                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                                    "toggleCountText": "units selected",
                                    "dropdownClasses": "mt-2 z-50 w-full max-h-56 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                    }'>

                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" unit-code="{{ $unit->code }}">
                                            {{ $unit->name }}</option>
                                    @endforeach
                                </select>
                                <div class="flex justify-between gap-x-1 text-sm">
                                    <button type="button" id="set-prodi" @click="setProdi"
                                        class="inline-flex items-center gap-x-1 rounded-lg border border-transparent bg-gray-100 px-2 py-1 text-gray-800 hover:bg-gray-200 disabled:pointer-events-none disabled:opacity-50 dark:bg-white/10 dark:text-white dark:hover:bg-white/20 dark:hover:text-white">
                                        <svg class="size-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5v14"></path>
                                        </svg>
                                        Set Prodi
                                    </button>
                                    <button type="button" id="set-jurusan" @click="setJurusan"
                                        class="inline-flex items-center gap-x-1 rounded-lg border border-transparent bg-gray-100 px-2 py-1 text-gray-800 hover:bg-gray-200 disabled:pointer-events-none disabled:opacity-50 dark:bg-white/10 dark:text-white dark:hover:bg-white/20 dark:hover:text-white">
                                        <svg class="size-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5v14"></path>
                                        </svg>
                                        Set Jurusan
                                    </button>
                                    <button type="button" id="set-lainnya" @click="setLainnya"
                                        class="inline-flex items-center gap-x-1 rounded-lg border border-transparent bg-gray-100 px-2 py-1 text-gray-800 hover:bg-gray-200 disabled:pointer-events-none disabled:opacity-50 dark:bg-white/10 dark:text-white dark:hover:bg-white/20 dark:hover:text-white">
                                        <svg class="size-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5v14"></path>
                                        </svg>
                                        Set lainnya
                                    </button>
                                    <button type="button" id="reset-multiple-value" @click="reset"
                                        class="inline-flex items-center gap-x-1 rounded-lg border border-gray-200 bg-white px-2 py-1 text-gray-800 hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:hover:bg-neutral-800">
                                        <svg class="size-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                            <path d="M3 3v5h5"></path>
                                            <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path>
                                            <path d="M16 16h5v5"></path>
                                        </svg>
                                        Reset value
                                    </button>
                                </div>
                            </div> --}}

                            <div class="flex flex-col gap-2">
                                <x-input-label for="name" :value="__('Tentukan Deadline')" />
                                <input name="deadline" id="date-input" datepicker-format="yyyy/mm/dd"
                                    type="datetime-local" value="{{ old('deadline') }}"
                                    class="w-full rounded-lg border-2 border-gray-200 bg-white py-2 pl-8 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="h-full w-full">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="sticky top-0 z-50 bg-white">
                                        <th class="w-1/2 p-4 text-sm">
                                            <h2
                                                class="whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white md:text-lg">
                                                {{ __('Daftarkan Unit Kerja') }}
                                            </h2>

                                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-300 md:text-sm">
                                                {{ __('Tentukan Pimpinan dan PIC') }}
                                            </p>
                                        </th>
                                        <th class="w-1/2 p-4 text-sm">
                                            <h2
                                                class="whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white md:text-lg">
                                                {{ __('Daftarkan Auditor') }}
                                            </h2>

                                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-300 md:text-sm">
                                                {{ __('Tentukan Ketua dan anggota') }}
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                {{-- <template x-for="(option, index) in selectedOptions" :key="option"> --}}
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="flex w-full justify-center md:px-20">
                                                <ul class="space-y-3">
                                                    <li>
                                                        <input value="Chief" readonly name="positions[]"
                                                            class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                                                    </li>
                                                    <li>
                                                        <input value="PIC" readonly name="positions[]"
                                                            class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                                                    </li>
                                                    <template x-for="(item, itemIndex) in auditees || []"
                                                        :key="item">
                                                        <li>
                                                            <input :value="'PIC ' + item.id" readonly
                                                                name="positions[]"
                                                                class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                                                        </li>
                                                    </template>
                                                </ul>
                                                <ul class="space-y-3">
                                                    {{-- <li class="flex items-center">
                                                        <div class="relative flex items-center">
                                                            <input type="hidden" x-model="pimpinan.id"
                                                                name="user_usernames[]" />
                                                            <input type="text" id="auditeeName-0"
                                                                x-model="pimpinan.user_name"
                                                                @input="searchUsers('auditee', 0)" name="user_names[]"
                                                                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                placeholder="Search User" />
                                                            <input type="hidden" id="auditeeUsername-0"
                                                                x-model="pimpinan.user_username"
                                                                name="user_usernames[]" />
                                                            <input type="hidden" id="auditeeEmail-0"
                                                                x-model="pimpinan.user_email" name="user_emails[]" />
                                                            <div x-show="showResults && currentRole === 'auditee' && currentItem === 0"
                                                                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                <template x-for="user in results"
                                                                    :key="user.PE_Email">
                                                                    <div @click="selectUser(user, 'pimpinan')"
                                                                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                        <span x-text="user.PE_Nama"></span>
                                                                    </div>
                                                                </template>
                                                                <div x-show="results.length === 0"
                                                                    class="px-4 py-2 text-sm text-gray-500">No users
                                                                    found</div>
                                                            </div>
                                                        </div>
                                                    </li> --}}
                                                    {{-- <li class="flex items-center">
                                                        <div class="relative flex items-center">
                                                            <input type="hidden" x-model="pic.id"
                                                                name="user_usernames[]" />
                                                            <input type="text" id="auditeeName-1"
                                                                x-model="pic.user_name"
                                                                @input="searchUsers('auditee', 1)" name="user_names[]"
                                                                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                placeholder="Search User" />
                                                            <input type="hidden" id="auditeeUsername-1"
                                                                x-model="pic.user_username" name="user_usernames[]" />
                                                            <input type="hidden" id="auditeeEmail-1"
                                                                x-model="pic.user_email" name="user_emails[]" />
                                                            <div x-show="showResults && currentRole === 'auditee' && currentItem === 1"
                                                                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                <template x-for="user in results"
                                                                    :key="user.PE_Email">
                                                                    <div @click="selectUser(user, 'pic')"
                                                                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                        <span x-text="user.PE_Nama"></span>
                                                                    </div>
                                                                </template>
                                                                <div x-show="results.length === 0"
                                                                    class="px-4 py-2 text-sm text-gray-500">No users
                                                                    found</div>
                                                            </div>
                                                        </div>
                                                    </li> --}}
                                                    <li class="flex items-center">
                                                        <div class="relative flex items-center">
                                                            <input type="text" id="auditeeName-0"
                                                                value="{{ optional($formAccesses->firstWhere('position', 'Chief'))->user->name ?? '' }}"
                                                                @input="searchUsers('auditee', 0)" name="user_names[]"
                                                                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                placeholder="Search User" />
                                                            <input type="hidden" id="auditeeUsername-0"
                                                                name="user_usernames[]" />
                                                            <input type="hidden" id="auditeeEmail-0"
                                                                name="user_emails[]" />
                                                            <div x-show="showResults && currentRole === 'auditee' && currentItem === 0"
                                                                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                <template x-for="user in results"
                                                                    :key="user.PE_Email">
                                                                    <div @click="selectUser(user, 'auditee', 0)"
                                                                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                        <span x-text="user.PE_Nama"></span>
                                                                    </div>
                                                                </template>
                                                                <div x-show="results.length === 0"
                                                                    class="px-4 py-2 text-sm text-gray-500">
                                                                    No users found
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="flex items-center">
                                                        <div class="relative flex items-center">
                                                            <input type="text" id="auditeeName-1"
                                                                x-model="pic.user_name"
                                                                @input="searchUsers('auditee', 1)" name="user_names[]"
                                                                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                placeholder="Search User" />
                                                            <input type="hidden" id="auditeeUsername-1"
                                                                name="user_usernames[]" />
                                                            <input type="hidden" id="auditeeEmail-1"
                                                                name="user_emails[]" />
                                                            <div x-show="showResults && currentRole === 'auditee' && currentItem === 1"
                                                                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                <template x-for="user in results"
                                                                    :key="user.PE_Email">
                                                                    <div @click="selectUser(user, 'auditee', 1)"
                                                                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                        <span x-text="user.PE_Nama"></span>
                                                                    </div>
                                                                </template>
                                                                <div x-show="results.length === 0"
                                                                    class="px-4 py-2 text-sm text-gray-500">
                                                                    No users found
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <template x-for="(item, itemIndex) in otherAccesses || []"
                                                        :key="item">
                                                        <li class="flex items-center">
                                                            <div class="relative flex items-center">
                                                                <input type="text" :id="'auditeeName-' + item.id"
                                                                    @input="searchUsers('auditee', item.id)"
                                                                    name="user_names[]" x-model="item.user.name"
                                                                    class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                    placeholder="Search User" />
                                                                <input type="hidden"
                                                                    :id="'auditeeUsername-' + item.id"
                                                                    name="user_usernames[]" />
                                                                <input type="hidden" :id="'auditeeEmail-' + item.id"
                                                                    name="user_emails[]" />
                                                                <div x-show="showResults && currentRole === 'auditee' && currentItem === item.id"
                                                                    class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                    <template x-for="user in results"
                                                                        :key="user.PE_Email">
                                                                        <div @click="selectUser(user, 'auditee', item.id)"
                                                                            class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                            <span x-text="user.PE_Nama"></span>
                                                                        </div>
                                                                    </template>
                                                                    <div x-show="results.length === 0"
                                                                        class="px-4 py-2 text-sm text-gray-500">
                                                                        No users found
                                                                    </div>
                                                                </div>
                                                                <button type="button"
                                                                    @click="removeItem('auditees', itemIndex)"
                                                                    class="ml-2 flex cursor-pointer items-center gap-x-2 rounded text-red-500 hover:text-red-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:border-purple-500 dark:hover:text-gray-200">
                                                                    <svg class="size-4 shrink-0 rounded-full"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <circle cx="12" cy="12" r="10">
                                                                        </circle>
                                                                        <path d="M8 12h8"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </li>
                                                    </template>
                                                    <div class="flex items-center justify-end">
                                                        <button type="button" @click="addItem('auditees')"
                                                            class="flex cursor-pointer items-center rounded text-green-400 hover:text-green-500 dark:bg-gray-700 dark:text-gray-400 dark:hover:border-purple-500 dark:hover:text-gray-200">
                                                            <span>Add Auditee</span>
                                                            <svg class="size-4 ml-2 shrink-0 rounded-full"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="10">
                                                                </circle>
                                                                <path d="M12 8v8"></path>
                                                                <path d="M8 12h8"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex w-full md:px-20">
                                                <ul class="space-y-3">
                                                    <li>
                                                        <input value="Leader" readonly name="positions[]"
                                                            class="items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                                                    </li>
                                                    <li>
                                                        <input value="Member" readonly name="positions[]"
                                                            class="items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                                                    </li>
                                                    <template x-for="(item, itemIndex) in auditors || []"
                                                        :key="item">
                                                        <li>
                                                            <input :value="'Member ' + item.id" readonly
                                                                name="positions[]"
                                                                class="items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
                                                        </li>
                                                    </template>
                                                </ul>
                                                <ul class="space-y-3">
                                                    <li class="flex items-center">
                                                        <div class="relative flex items-center">
                                                            <input type="text" id="auditorName-0"
                                                                @input="searchUsers('auditor', 0)" name="user_names[]"
                                                                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                placeholder="Search User" />
                                                            <input type="hidden" id="auditorUsername-0"
                                                                name="user_usernames[]" />
                                                            <input type="hidden" id="auditorEmail-0"
                                                                name="user_emails[]" />
                                                            <div x-show="showResults && currentRole === 'auditor' && currentItem === 0"
                                                                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                <template x-for="user in results"
                                                                    :key="user.PE_Email">
                                                                    <div @click="selectUser(user, 'auditor', 0)"
                                                                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                        <span x-text="user.PE_Nama"></span>
                                                                    </div>
                                                                </template>
                                                                <div x-show="results.length === 0"
                                                                    class="px-4 py-2 text-sm text-gray-500">
                                                                    No users found
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="flex items-center">
                                                        <div class="relative flex items-center">
                                                            <input type="text" id="auditorName-1"
                                                                @input="searchUsers('auditor', 1)" name="user_names[]"
                                                                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                placeholder="Search User" />
                                                            <input type="hidden" id="auditorUsername-1"
                                                                name="user_usernames[]'" />
                                                            <input type="hidden" id="auditorEmail-1"
                                                                name="user_emails[]" />
                                                            <div x-show="showResults && currentRole === 'auditor' && currentItem === 1"
                                                                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                <template x-for="user in results"
                                                                    :key="user.PE_Email">
                                                                    <div @click="selectUser(user, 'auditor', 1)"
                                                                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                        <span x-text="user.PE_Nama"></span>
                                                                    </div>
                                                                </template>
                                                                <div x-show="results.length === 0"
                                                                    class="px-4 py-2 text-sm text-gray-500">
                                                                    No users found
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <template x-for="(item, itemIndex) in auditors || []"
                                                        :key="item">
                                                        <li class="flex items-center">
                                                            <div class="relative flex items-center">
                                                                <input type="text" :id="'auditorName-' + item.id"
                                                                    @input="searchUsers('auditor', item.id)"
                                                                    name="user_names[]"
                                                                    class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                                                                    placeholder="Search User" />
                                                                <input type="hidden"
                                                                    :id="'auditorUsername-' + item.id"
                                                                    name="user_usernames[]" />
                                                                <input type="hidden" :id="'auditorEmail-' + item.id"
                                                                    name="user_emails[]" />
                                                                <div x-show="showResults && currentRole === 'auditor' && currentItem === item.id"
                                                                    class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                                                                    <template x-for="user in results"
                                                                        :key="user.PE_Email">
                                                                        <div @click="selectUser(user, 'auditor', item.id)"
                                                                            class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                                                                            <span x-text="user.PE_Nama"></span>
                                                                        </div>
                                                                    </template>
                                                                    <div x-show="results.length === 0"
                                                                        class="px-4 py-2 text-sm text-gray-500">
                                                                        No users found
                                                                    </div>
                                                                </div>
                                                                <button type="button"
                                                                    @click="removeItem(option, 'auditors', itemIndex)"
                                                                    class="ml-2 flex cursor-pointer items-center gap-x-2 rounded text-red-500 hover:text-red-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:border-purple-500 dark:hover:text-gray-200">
                                                                    <svg class="size-4 shrink-0 rounded-full"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <circle cx="12" cy="12" r="10">
                                                                        </circle>
                                                                        <path d="M8 12h8"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </li>
                                                    </template>
                                                    <div class="flex items-center justify-end">
                                                        <button type="button" @click="addItem('auditors')"
                                                            class="flex cursor-pointer items-center rounded text-green-400 hover:text-green-500 dark:bg-gray-700 dark:text-gray-400 dark:hover:border-purple-500 dark:hover:text-gray-200">
                                                            <span>Add Auditor</span>
                                                            <svg class="size-4 ml-2 shrink-0 rounded-full"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="10">
                                                                </circle>
                                                                <path d="M12 8v8"></path>
                                                                <path d="M8 12h8"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                {{-- </template> --}}
                            </table>
                        </div>

                    </div>
                    <!-- End First Content -->

                    <!-- Second Content -->
                    <div class="h-full w-full" data-hs-stepper-content-item='{"index": 2}' style="display: none;">
                    </div>
                    <!-- End Second Content -->

                    <!-- Third Content -->
                    <div class="h-full w-full p-2" data-hs-stepper-content-item='{"index": 3}'
                        style="display: none;">
                        <div class="h-full w-full font-semibold" x-data="{
                            openTab: {{ $categories->isNotEmpty() ? $categories->first()->id : 1 }},
                            categories: [
                                @forelse ($categories as $index => $category) {
                                    id: {{ $category['id'] }},
                                    name: '{{ $category['name'] }}',
                                    standards: [
                                    @if (isset($standardsByCategory[$category['id']]))
                                        @foreach ($standardsByCategory[$category['id']] as $standardIndex => $standard)
                                        {
                                            id: {{ $standard['id'] }},
                                            category_id: '{{ $category['id'] }}',
                                            name: '{{ $standard['name'] }}',
                                            competencies: [
                                                @if (isset($competenciesByStandard[$standard['id']]))
                                                    @foreach ($competenciesByStandard[$standard['id']] as $competency)
                                                    {
                                                        id: {{ $competency['id'] }},
                                                        standard_id: '{{ $standard['id'] }}',
                                                        name: '{{ $competency['name'] }}',
                                                        indicators: [
                                                            @if (isset($indicatorsByCompetency[$competency['id']]))
                                                                @foreach ($indicatorsByCompetency[$competency['id']] as $indicator)
                                                                {
                                                                    id: {{ $indicator['id'] }},
                                                                    competency_id: '{{ $competency['id'] }}',
                                                                    code: '{{ $indicator['code'] }}',
                                                                    assessment: '{{ $indicator['assessment'] }}',
                                                                    entry: '{{ $indicator['entry'] }}',
                                                                    rate_option: '{{ $indicator['rate_option'] }}',
                                                                    info: '{{ $indicator['info'] }}',
                                                                    isDisabled: false
                                                                }, @endforeach
                                                            @else
                                                                { id: 1, competency_id: '', code: '', assessment: '',  entry: '', rate_option: '', info: '' }
                                                            @endif
                                                        ]
                                                    },
                                                    @endforeach
                                                @else
                                                    { id: 1, name: '', standard_id: '', indicators: [] }
                                                @endif
                                            ]
                                        },
                                        @endforeach
                                    @else { id: 1, name: '', category_id: '', competencies: [] }
                                    @endif
                                    ]
                                },
                                @empty { id: 1, name: '', standards: [] } @endforelse
                            ],
                            toggleDisableIndicator(standardId, competencyId, indicatorId) {
                                let category = this.categories.find(cat => cat.id === this.openTab);
                                let indicator = category.standards[standardId].competencies[competencyId].indicators[indicatorId];
                        
                                indicator.isDisabled = !indicator.isDisabled;
                            }
                        }">

                            <div class="mb-2 flex justify-between gap-x-2">
                                <div class="flex w-[70%] whitespace-nowrap" data-simplebar>
                                    <ul class="flex">
                                        <template x-for="(category, index) in categories" :key="category.id">
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

                                {{-- <div class="hs-dropdown z-10">
                                    <button id="hs-dropdown-default" type="button"
                                        class="hs-dropdown-toggle flex items-center gap-x-1 rounded border-2 border-gray-200 bg-white px-1.5 py-1 font-semibold text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50 focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-800 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                                        aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                        Periode
                                        <svg class="size-4 hs-dropdown-open:rotate-180"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>
                                    <div class="hs-dropdown-menu duration min-w-60 mt-2 hidden space-y-0.5 rounded-lg bg-white p-1 opacity-0 shadow-md transition-[opacity,margin] before:absolute before:-top-4 before:start-0 before:h-4 before:w-full after:absolute after:-bottom-4 after:start-0 after:h-4 after:w-full hs-dropdown-open:opacity-100 dark:divide-neutral-700 dark:border dark:border-neutral-700 dark:bg-neutral-800"
                                        role="menu" aria-orientation="vertical"
                                        aria-labelledby="hs-dropdown-default">
                                        @if ($documents->count())
                                            @foreach ($documents as $id => $document)
                                                <a class="flex items-center justify-between gap-x-3.5 rounded-lg px-3 py-2 text-gray-800 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700"
                                                    href="{{ route('documents.create', ['template' => $document]) }}">
                                                    {{ $document }}
                                                    @if ($documentId == $id)
                                                        <svg class="size-4 flex-shrink-0 text-blue-600"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M20 6 9 17l-5-5"></path>
                                                        </svg>
                                                    @endif
                                                </a>
                                            @endforeach
                                        @else
                                            <a
                                                class="flex items-center gap-x-3.5 rounded-lg px-3 py-2 text-gray-800 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700">
                                                No document found
                                            </a>
                                        @endif
                                    </div>
                                </div> --}}

                            </div>

                            <div
                                class="shadow-xs h-[90%] w-full overflow-y-auto rounded-b rounded-r border-2 border-gray-200 bg-white px-3 py-1 text-center scrollbar-thin dark:border-gray-500 dark:bg-gray-700 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                                <template x-for="(category, index) in categories" :key="category.id">
                                    <div x-show="openTab === category.id">
                                        <template x-for="(standard, standardIndex) in category.standards"
                                            :key="standard.id">
                                            <div class="mb-5">
                                                <div class="flex items-center justify-start gap-x-2">
                                                    <div x-text="standard.name"
                                                        class="min-w-52 border-0 border-indigo-800 bg-white pl-2 text-left text-lg font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400"
                                                        x-bind:style="{ width: (standard.name.length + 1) + 'ch' }"
                                                        placeholder="Enter Standard Name">
                                                    </div>
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
                                                            <th
                                                                class="w-[18%] border border-indigo-800 font-semibold dark:border-gray-400 dark:text-white">
                                                                Validation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template
                                                            x-for="(competency, competencyIndex) in standard.competencies"
                                                            :key="competency.id">
                                                            <tr>
                                                                <td
                                                                    class="border border-blue-800 p-3 dark:border-gray-500 dark:text-white">
                                                                    <div x-text="competency.name"
                                                                        style="text-align: justify;"
                                                                        class="w-full text-indigo-800">
                                                                    </div>
                                                                </td>
                                                                <td colspan="2"
                                                                    class="border border-blue-800 p-3 dark:border-gray-500 dark:text-white">
                                                                    <template
                                                                        x-for="(indicator, indicatorIndex) in competency.indicators"
                                                                        :key="indicator.id">
                                                                        <div
                                                                            class="my-5 flex w-full items-center justify-between">
                                                                            <div
                                                                                class="flex w-8/12 flex-col items-center justify-between gap-x-5 gap-y-2 md:flex-row">
                                                                                <div class="flex items-center gap-x-5">
                                                                                    <template
                                                                                        x-if="!indicator
                                                                                        .isDisabled">
                                                                                        <button type="button"
                                                                                            @click="toggleDisableIndicator(standardIndex, competencyIndex, indicatorIndex)"
                                                                                            class="rounded-full text-gray-500 hover:text-red-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                                            <svg class="w-5 text-center"
                                                                                                aria-hidden="true"
                                                                                                fill="none"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                stroke-width="2"
                                                                                                viewBox="0 0 24 24"
                                                                                                stroke="currentColor">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88">
                                                                                                </path>
                                                                                            </svg>
                                                                                        </button>
                                                                                    </template>
                                                                                    <template
                                                                                        x-if="indicator
                                                                                        .isDisabled">
                                                                                        <button type="button"
                                                                                            @click="toggleDisableIndicator(standardIndex, competencyIndex, indicatorIndex)"
                                                                                            class="rounded-full text-gray-500 hover:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                                            <svg class="w-5 text-center"
                                                                                                aria-hidden="true"
                                                                                                fill="none"
                                                                                                stroke-linecap="round"
                                                                                                stroke-linejoin="round"
                                                                                                stroke-width="2"
                                                                                                viewBox="0 0 24 24"
                                                                                                stroke="currentColor">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z">
                                                                                                </path>
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z">
                                                                                                </path>
                                                                                            </svg>
                                                                                        </button>
                                                                                    </template>
                                                                                    <input type="hidden"
                                                                                        :disabled="indicator.isDisabled"
                                                                                        x-model="indicator.id"
                                                                                        name="indicators_id[]" />
                                                                                    <div x-text="indicator.code"
                                                                                        class="border-0 border-indigo-800 bg-transparent text-sm font-semibold text-indigo-800 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400">
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Indicator assessment field -->
                                                                                <div x-text="indicator.assessment"
                                                                                    class="w-full border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent font-semibold text-indigo-800"
                                                                                    :class="{ 'hidden': indicator.isDisabled }"
                                                                                    style="text-align: justify;">
                                                                                </div>
                                                                            </div>
                                                                            {{-- Validation --}}
                                                                            <template
                                                                                x-if="!indicator
                                                                                        .isDisabled">
                                                                                <div
                                                                                    class="w-3/12 items-center justify-between gap-4 align-middle md:flex">
                                                                                    <div class="hidden text-xs font-bold text-indigo-800 md:block"
                                                                                        style="text-align: justify"
                                                                                        x-text="
                                                                                        indicator.entry === 'Option' ? indicator.entry + ' (Yes/No)' :
                                                                                        indicator.entry === 'Digit' ? indicator.entry + ' (#)' :
                                                                                        indicator.entry === 'Decimal' ? indicator.entry + ' (.)' :
                                                                                        indicator.entry === 'Cost' ? indicator.entry + ' ($)' :
                                                                                        indicator.entry === 'Percentage' ? indicator.entry + ' (%)' :
                                                                                        indicator.rate_option === '1-10' ? indicator.entry + ' (1/10)' :
                                                                                        indicator.rate_option === '1-100' ? indicator.entry + ' (1/100)' : ''">
                                                                                    </div>
                                                                                    <!-- md: Popover -->
                                                                                    <div
                                                                                        class="hs-tooltip hidden items-center justify-center [--trigger:hover] md:flex">
                                                                                        <div class="hs-tooltip-toggle">
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
                                                                                    <!-- End md: Popover -->

                                                                                    <!-- Popover -->
                                                                                    <div
                                                                                        class="hs-tooltip flex items-center justify-center [--trigger:hover] md:hidden">
                                                                                        <div class="hs-tooltip-toggle">
                                                                                            <button type="button"
                                                                                                class="text-gray-500 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                                                <svg class="size-5"
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
                                                                                                    class="px-4 pt-3 text-lg font-bold text-gray-800 dark:text-white">Validation</span>
                                                                                                <div
                                                                                                    class="flex flex-col gap-2 px-4 py-3 text-sm text-gray-600 dark:text-neutral-400">
                                                                                                    <p
                                                                                                        x-text="indicator.entry">
                                                                                                    </p>
                                                                                                    <p
                                                                                                        x-text="indicator.rate_option">
                                                                                                    </p>
                                                                                                    <p
                                                                                                        x-text="indicator.info">
                                                                                                    </p>
                                                                                                    <p
                                                                                                        x-show="!indicator.info">
                                                                                                        No info
                                                                                                        verification
                                                                                                        link</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- End Popover -->
                                                                                </div>
                                                                            </template>
                                                                            {{-- End Validation --}}
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
                                </template>
                                <div x-show="categories.length === 0"
                                    class="flex h-full flex-col items-center justify-center gap-2 text-gray-500">
                                    <div>No documents available. Please add some document first.
                                        <a href="/documents/create" target="_blank"
                                            class="rounded bg-green-400 px-2 py-0.5 text-center text-sm font-medium text-white transition hover:border-green-500 hover:bg-green-500">
                                            Add Document
                                            <i class="far fa-plus-square ml-2"></i>
                                        </a>
                                    </div>
                                    <a href="#" target="_blank"
                                        class="rounded bg-green-400 px-2 py-1 text-center text-sm font-medium text-white transition hover:border-green-500 hover:bg-green-500">
                                        Refresh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Third Content -->

                    <!-- Final Content -->
                    {{-- <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
                        <h3 class="text-gray-500 dark:text-neutral-500">
                            Final content
                        </h3>
                    </div> --}}
                    <!-- End Final Content -->
                </div>
                <!-- Button Group -->
                <div class="mt-2 flex items-center justify-between gap-x-2">
                    <button type="button"
                        class="inline-flex items-center gap-x-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50 focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                        data-hs-stepper-back-btn="">
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                        Back
                    </button>
                    <button type="button"
                        class="inline-flex items-center gap-x-1 rounded-lg border border-transparent bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                        data-hs-stepper-next-btn="">
                        Next
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </button>
                    {{-- <button type="button"
                        class="inline-flex items-center gap-x-1 rounded-lg border border-transparent bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                        data-hs-stepper-finish-btn="" style="display: none;">
                        Finish
                    </button> --}}
                    <button type="submit"
                        class="inline-flex items-center gap-x-1 rounded-lg border border-transparent bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                        data-hs-stepper-finish-btn="" style="display: none;">
                        Submit
                    </button>
                    {{-- <button type="reset"
                        class="inline-flex items-center gap-x-1 rounded-lg border border-transparent bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                        data-hs-stepper-reset-btn="" style="display: none;">
                        Reset
                    </button> --}}
                </div>
                <!-- End Button Group -->
            </form>
            <!-- End Stepper Content -->
        </div>
    </div>

    {{-- <script>
        function script() {
            return {
                pimpinan: {
                    id: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->id ?? '' }}',
                    user_name: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->user->name ?? '' }}',
                    user_username: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->user->username ?? '' }}',
                    user_email: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->user->email ?? '' }}'
                },
                pic: {
                    id: '{{ $formAccesses->firstWhere('position', 'PIC')->id ?? '' }}',
                    user_name: '{{ $formAccesses->firstWhere('position', 'PIC')->user->name ?? '' }}',
                    user_username: '{{ $formAccesses->firstWhere('position', 'PIC')->user->username ?? '' }}',
                    user_email: '{{ $formAccesses->firstWhere('position', 'PIC')->user->email ?? '' }}'
                },
                otherAccesses: {!! json_encode($formAccesses->filter(fn($item) => Str::startsWith($item->position, 'PIC '))->toArray()) !!},
                results: [],
                showResults: false,
                currentItem: null,
                currentRole: null,
                searchUsers(role, item) {
                    console.log(this.otherAccesses);
                    let input; // Declare input outside the conditionals

                    if (role === 'auditee') {
                        input = document.getElementById(`auditeeName-${item}`);
                    } else if (role === 'auditor') {
                        input = document.getElementById(`auditorName-${item}`);
                    }

                    const query = input.value;

                    if (query.length > 2) {
                        const url =
                            `https://api-gerbang.itk.ac.id/api/siakad/pegawai/search?keyword=${encodeURIComponent(query)}`;
                        const token = '119961|e1jvJWYHODtLf4u15duHkFeb4qpPmuz97f2DhfiV'
                        fetch(url, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute(
                                        'content'),
                                    Authorization: 'Bearer ' + token,
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.data.length > 0) {
                                    this.results = data.data;
                                } else {
                                    this.results = [];
                                }
                                this.showResults = true;
                                this.currentRole = role;
                                this.currentItem = item;
                            })
                            .catch(error => {
                                console.error('Error fetching users:', error);
                            });
                    } else {
                        this.results = [];
                        this.showResults = false;
                    }
                },
                selectUser(user, role) {
                    if (role === 'pimpinan') {
                        this.pimpinan.user_name = user.PE_Nama;
                        this.pimpinan.user_username = user.PE_Nip;
                        this.pimpinan.user_email = user.PE_Email;
                    } else if (role === 'pic') {
                        this.pic.user_name = user.PE_Nama;
                        this.pic.user_username = user.PE_Nip;
                        this.pic.user_email = user.PE_Email;
                    }

                    this.showResults = false; // Hide the results dropdown after selection
                },

                auditees: [],
                auditors: [],
                addItem(role) {
                    this[role].push({});
                    // Memperbarui ID untuk semua item
                    this.updateIds(role);
                },
                removeItem(role, itemIndex) {
                    this[role].splice(itemIndex, 1);
                    this.updateIds(role);
                },
                updateIds(role) {
                    // Memperbarui hanya properti 'id' dari setiap item, tanpa memodifikasi properti lainnya
                    this[role].forEach((item, index) => {
                        item.id = index + 2; // ID mulai dari 2 seperti yang diinginkan
                    });
                }
            };
        }
    </script> --}}

    <script>
        function script() {
            return {
                pimpinan: {
                    id: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->id ?? '' }}',
                    user_name: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->user->name ?? '' }}',
                    user_username: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->user->username ?? '' }}',
                    user_email: '{{ $formAccesses->firstWhere('position', 'Pimpinan')->user->email ?? '' }}'
                },
                pic: {
                    id: '{{ $formAccesses->firstWhere('position', 'PIC')->id ?? '' }}',
                    user_name: '{{ $formAccesses->firstWhere('position', 'PIC')->user->name ?? '' }}',
                    user_username: '{{ $formAccesses->firstWhere('position', 'PIC')->user->username ?? '' }}',
                    user_email: '{{ $formAccesses->firstWhere('position', 'PIC')->user->email ?? '' }}'
                },
                // otherAccesses: {!! json_encode($formAccesses->filter(fn($item) => Str::startsWith($item->position, 'PIC '))->toArray()) !!},
                otherAccesses: Object.values({!! json_encode($formAccesses->filter(fn($item) => Str::startsWith($item->position, 'PIC '))->toArray()) !!}),
                results: [],
                showResults: false,
                currentItem: null,
                currentRole: null,
                searchUsers(role, item) {
                    let input; // Declare input outside the conditionals

                    if (role === 'auditee') {
                        input = document.getElementById(`auditeeName-${item}`);
                    } else if (role === 'auditor') {
                        input = document.getElementById(`auditorName-${item}`);
                    }

                    const query = input.value;

                    if (query.length > 2) {
                        const url =
                            `https://api-gerbang.itk.ac.id/api/siakad/pegawai/search?keyword=${encodeURIComponent(query)}`;
                        const token = '119961|e1jvJWYHODtLf4u15duHkFeb4qpPmuz97f2DhfiV'
                        fetch(url, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute(
                                        'content'),
                                    Authorization: 'Bearer ' + token,
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.data.length > 0) {
                                    this.results = data.data;
                                } else {
                                    this.results = [];
                                }
                                this.showResults = true;
                                this.currentRole = role;
                                this.currentItem = item;
                            })
                            .catch(error => {
                                console.error('Error fetching users:', error);
                            });
                    } else {
                        this.results = [];
                        this.showResults = false;
                    }
                },
                selectUser(user, role, item) {
                    let nameInput; // Declare input outside the conditionals
                    let usernameInput; // Declare input outside the conditionals
                    let emailInput; // Declare input outside the conditionals

                    if (role === 'auditee') {
                        nameInput = document.getElementById(`auditeeName-${item}`);
                        usernameInput = document.getElementById(`auditeeUsername-${item}`);
                        emailInput = document.getElementById(`auditeeEmail-${item}`);
                    } else if (role === 'auditor') {
                        nameInput = document.getElementById(`auditorName-${item}`);
                        usernameInput = document.getElementById(`auditorUsername-${item}`);
                        emailInput = document.getElementById(`auditorEmail-${item}`);
                    }
                    nameInput.value = user.PE_Nama;
                    usernameInput.value = user.PE_Nip;
                    emailInput.value = user.PE_Email;

                    this.showResults = false;
                },
                auditees: [],
                auditors: [],
                addItem(role) {
                    // if (!this[role]) {
                    //     this[role] = [];
                    // }
                    this[role].push({});
                    // Memperbarui ID untuk semua item
                    this.updateIds(role);
                },
                removeItem(role, itemIndex) {
                    this[role].splice(itemIndex, 1);
                    this.updateIds(role);
                },
                updateIds(role) {
                    // Memperbarui hanya properti 'id' dari setiap item, tanpa memodifikasi properti lainnya
                    this[role].forEach((item, index) => {
                        item.id = index + 2; // ID mulai dari 2 seperti yang diinginkan
                    });
                }
            };
        }
    </script>
</x-app-layout>
