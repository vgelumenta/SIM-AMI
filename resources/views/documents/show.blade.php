<x-app-layout>
    <div class="flex h-full w-full flex-col gap-y-1">

        <div
            class="flex items-center justify-between font-semibold text-blue-800 dark:text-cool-gray-50 sm:text-lg">
            <ol class="flex items-center gap-x-2">
                <li>
                    <a href="/documents" class="hover:underline">
                        Documents
                    </a>
                </li>
                <li>
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li>
                    {{ $document->name }}
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

        <div class="h-[85%] w-full font-semibold" x-data="{
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
                                        statement: '{{ str_replace(["\r\n", "\r", "\n"], "\\n", e($competency['statement'])) }}',
                                        indicators: [
                                            @if (isset($indicatorsByCompetency[$competency['id']]))
                                                @foreach ($indicatorsByCompetency[$competency['id']] as $indicator)
                                                {
                                                    id: {{ $indicator['id'] }},
                                                    competency_id: '{{ $competency['id'] }}',
                                                    code: '{{ $indicator['code'] }}',
                                                    assessment: '{{ str_replace(["\r\n", "\r", "\n"], "\\n", e($indicator['assessment'])) }}',
                                                    entry: '{{ $indicator['entry'] }}',
                                                    link_info: '{{ str_replace(["\r\n", "\r", "\n"], "\\n", e($indicator['link_info'])) }}',
                                                    rate_option: '{{ $indicator['rate_option'] }}',
                                                    disable_text: '{{ str_replace(["\r\n", "\r", "\n"], "\\n", e($indicator['disable_text'])) }}',
                                                    isDisabled: false
                                                }, @endforeach
                                            @else
                                                { id: 1, competency_id: '', code: '', assessment: '',  entry: '', link_info: '', rate_option: '', disable_text: '' }
                                            @endif
                                        ]
                                    },
                                    @endforeach
                                @else
                                    { id: 1, statement: '', standard_id: '', indicators: [] }
                                @endif
                            ]
                        },
                        @endforeach
                    @else { id: 1, name: '', category_id: '', competencies: [] }
                    @endif
                    ]
                },
                @empty { id: 1, name: '', standards: [] } @endforelse
            ]
        }">

            <div class="mb-2 flex justify-between gap-x-2">
                <div class="flex w-full whitespace-nowrap" data-simplebar>
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

            </div>

            <div
                class="shadow-xs h-[90%] w-full overflow-y-auto rounded-b rounded-r border-2 border-gray-200 bg-white px-3 py-1 text-center scrollbar-thin dark:border-gray-500 dark:bg-gray-700 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                <template x-for="(category, index) in categories" :key="category.id">
                    <div x-show="openTab === category.id">
                        <template x-for="(standard, standardIndex) in category.standards" :key="standard.id">
                            <div class="mb-5">
                                <div class="flex items-center justify-start gap-x-2">
                                    <div x-text="standard.name"
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
                                            <th
                                                class="w-[18%] border border-indigo-800 font-semibold dark:border-gray-400 dark:text-white">
                                                Validation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(competency, competencyIndex) in standard.competencies"
                                            :key="competency.id">
                                            <tr>
                                                <td
                                                    class="border border-blue-800 p-3 dark:border-gray-500 dark:text-white">
                                                    <div x-text="competency.statement" style="text-align: justify;"
                                                        class="w-full text-indigo-800">
                                                    </div>
                                                </td>
                                                <td colspan="2"
                                                    class="border border-blue-800 p-3 dark:border-gray-500 dark:text-white">
                                                    <template
                                                        x-for="(indicator, indicatorIndex) in competency.indicators"
                                                        :key="indicator.id">
                                                        <div class="my-5 flex w-full items-center justify-between">
                                                            <div
                                                                class="flex w-8/12 flex-col items-center justify-between gap-x-5 gap-y-2 md:flex-row">
                                                                <div class="flex items-center gap-x-5">
                                                                    <input type="hidden"
                                                                        :disabled="indicator.isDisabled"
                                                                        x-model="indicator.id" name="indicators_id[]" />
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
                                                                        indicator.rate_option === '1-100' ? indicator.entry + ' (1/100)' :
                                                                        indicator.entry === 'Disable' ? indicator.disable_text : ''">
                                                                </div>
                                                                <!-- md: Popover -->
                                                                <div x-show="
                                                                    ['Option', 'Digit', 'Decimal', 'Cost', 'Percentage', 'Rate'].includes(indicator.entry)"
                                                                    class="hs-tooltip hidden items-center justify-center [--trigger:hover] md:flex">
                                                                    <div class="hs-tooltip-toggle">
                                                                        <button type="button"
                                                                            class="text-gray-500 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                            <svg class="size-6"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path stroke-linecap="round"
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
                                                                                <p x-text="indicator.link_info">
                                                                                </p>
                                                                                <p x-show="!indicator.link_info"
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
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path stroke-linecap="round"
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
                                                                                <p x-text="indicator.entry">
                                                                                </p>
                                                                                <p x-show="!indicator.link_info">
                                                                                    No info
                                                                                    verification
                                                                                    link</p>
                                                                                <p x-text="indicator.disable_text">
                                                                                </p>
                                                                                <p x-text="indicator.rate_option">
                                                                                </p>
                                                                                <p x-text="indicator.link_info">
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End Popover -->
                                                            </div>
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

        {{-- <div class="space-x-10 text-right">
            @if ($userRole == 'PJM')
                <form action="{{ route('documents.destroy', $document) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Apakah Anda yakin ingin menghapus data?');"
                        class="rounded-md bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-700">
                        {{ __('Delete') }}
                    </button>
                </form>
            @endif
        </div> --}}
    </div>

</x-app-layout>
