<x-app-layout>
    <form action="/documents" method="POST" class="flex h-full w-full flex-col gap-y-1">
        @csrf

        <div class="flex items-center justify-between font-semibold text-blue-800 dark:text-cool-gray-50 sm:text-lg">
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
                    <input type="text" name="document_name" value="{{ $draft }}" readonly
                        class="border-0 border-indigo-800 bg-transparent p-0 text-lg font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400"
                        x-bind:style="'width: ' + (standard.name.length + 1) + 'ch;'" />
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
            openTab: 1,
            categories: [
                @forelse ($categories as $index => $category) {
                id: {{ $category['id'] }},
                name: '{{ $category['name'] }}',
                standards: [
                @if (isset($standardsByCategory[$category['id']]))
                    @foreach ($standardsByCategory[$category['id']] as $standardIndex => $standard) {
                        id: {{ $standard['id'] }},
                        category_id: '{{ $category['id'] }}',
                        name: '{{ $standard['name'] }}',
                        competencies: [
                        @if (isset($competenciesByStandard[$standard['id']]))
                            @foreach ($competenciesByStandard[$standard['id']] as $competency) {
                                id: {{ $competency['id'] }},
                                standard_id: '{{ $standard['id'] }}',
                                statement: '{{ $competency['statement'] }}',
                                indicators: [
                                    @if (isset($indicatorsByCompetency[$competency['id']]))
                                        @foreach ($indicatorsByCompetency[$competency['id']] as $indicator) {
                                            id: {{ $indicator['id'] }},
                                            competency_id: '{{ $competency['id'] }}',
                                            code: '{{ $indicator['code'] }}',
                                            assessment: '{{ $indicator['assessment'] }}',
                                            entry: '{{ $indicator['entry'] }}',
                                            rate_option: '{{ $indicator['rate_option'] }}',
                                            disable_text: '{{ $indicator['disable_text'] }}',
                                            info: '{{ $indicator['info'] }}',
                                        }, @endforeach
                                    @else
                                        { id: 1, competency_id: 1, code: '', assessment: '',  entry: '', rate_option: '', disable_text: '', info: '' }
                                    @endif
                                ]
                            }, @endforeach
                        @else
                            { id: 1, standard_id: 1, statement: '', indicators: [] }
                        @endif
                        ]
                    }, @endforeach
                @else
                    { id: 1, category_id: 1, name: '', competencies: [] }
                @endif
                ]
            }, @empty 
            { id: 1, name: '', standards: [] }  @endforelse
            ],
            updateAllIds() {
                let categoryId = 1,
                    standardId = 1,
                    competencyId = 1,
                    indicatorId = 1;
        
                this.categories.forEach((category) => {
                    category.id = categoryId++;
                    let indicatorIndex = 1
        
                    category.standards.forEach((standard) => {
                        standard.id = standardId++;
                        standard.category_id = category.id; // Assign the parent category id
        
                        standard.competencies.forEach((competency) => {
                            competency.id = competencyId++;
                            competency.standard_id = standard.id; // Assign the parent standard id
        
                            competency.indicators.forEach((indicator) => {
                                indicator.id = indicatorId++;
                                indicator.competency_id = competency.id; // Assign the parent competency id
        
                                // Generate the indicator code based on category.id and indicator.id
                                let categoryLetter = String.fromCharCode(64 + category.id) + '.' + indicatorIndex++; // Convert category.id to a letter (A, B, C, ...)
                                indicator.code = categoryLetter;
                            });
                        });
                    });
                });
            },
            addTab() {
                this.categories.push({ id: 0, name: '', standards: [] });
                this.updateAllIds();
                this.openTab = this.categories[this.categories.length - 1].id;
            },
            removeTab(tabId) {
                let index = this.categories.findIndex(cat => cat.id === tabId);
                this.categories.splice(index, 1);
                this.updateAllIds();
                if (this.openTab === tabId) {
                    this.openTab = this.categories.length < tabId ? this.categories.length : tabId;
                } else if (this.openTab > tabId) {
                    this.openTab = this.categories.length;
                }
            },
            addStandard() {
                let category = this.categories.find(cat => cat.id === this.openTab);
                category.standards.push({
                    id: 0,
                    name: '',
                    competencies: []
                });
                this.updateAllIds();
            },
            removeStandard(standardId) {
                let category = this.categories.find(cat => cat.id === this.openTab);
                category.standards.splice(standardId, 1);
                this.updateAllIds();
            },
            addCompetency(standardId) {
                let category = this.categories.find(cat => cat.id === this.openTab);
                category.standards[standardId].competencies.push({
                    id: 0,
                    statement: '',
                    indicators: []
                });
                this.updateAllIds();
            },
            removeCompetency(standardId, competencyId) {
                let category = this.categories.find(cat => cat.id === this.openTab);
                category.standards[standardId].competencies.splice(competencyId, 1);
                this.updateAllIds();
            },
            addIndicator(standardId, competencyId) {
                let category = this.categories.find(cat => cat.id === this.openTab);
        
                // Hitung ID baru untuk indikator
                let newIndicatorId = category.standards[standardId].competencies[competencyId].indicators.length + 1
                category.standards[standardId].competencies[competencyId].indicators.push({
                    id: 0,
                    assessment: '',
                    code: ''
        
                });
                this.updateAllIds();
            },
            removeIndicator(standardId, competencyId, indicatorId) {
                let category = this.categories.find(cat => cat.id === this.openTab);
                category.standards[standardId].competencies[competencyId].indicators.splice(indicatorId, 1);
                this.updateAllIds();
            },
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
            isOpenTabInvalid() {
                return !this.categories.some(category => category.id === this.openTab);
            },
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
                indicator = event.target.value;
            }
        }">

            <div class="flex justify-between gap-2">
                <div class="flex w-full whitespace-nowrap" data-simplebar>
                    <ul class="mb-2 flex">
                        <template x-for="(category, index) in categories" :key="category.id">
                            <li @click.prevent="openTab = category.id"
                                :class="openTab === category.id ?
                                    'text-indigo-800 dark:text-purple-400 border border-indigo-800 dark:border-gray-500' :
                                    'border-2 border-gray-200 text-gray-500 dark:text-gray-400 hover:text-green-400 dark:hover:text-gray-200 hover:border hover:border-indigo-800 dark:hover:border-purple-500'"
                                class="mr-1 flex cursor-pointer items-center gap-x-2 rounded bg-white p-1 dark:bg-gray-700">
                                <input type="hidden" x-model="category.id" :name="'categories[' + index + '][id]'" />
                                <input type="text" x-model="category.name" :name="'categories[' + index + '][name]'"
                                    class="w-36 border-0 border-indigo-800 bg-white p-0 text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400"
                                    placeholder="Enter Tab Name" />
                                <button type="button" @click.stop="removeTab(category.id)"
                                    class="rounded-full text-gray-500 hover:text-red-600 dark:text-neutral-600 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg>
                                </button>
                            </li>
                        </template>
                        <li @click="addTab()"
                            class="flex cursor-pointer items-center gap-x-2 rounded border-2 border-gray-200 bg-white p-1 text-green-400 hover:border hover:border-green-400 hover:text-green-400 dark:bg-gray-700 dark:text-gray-400 dark:hover:border-purple-500 dark:hover:text-gray-200">
                            <span>Add Tab</span>
                            <button type="button"
                                class="rounded-full dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 8v8"></path>
                                    <path d="M8 12h8"></path>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>

            </div>

            <div
                class="shadow-xs h-[90%] w-full overflow-y-auto rounded-b rounded-r border-2 border-gray-200 bg-white p-1 text-center scrollbar-thin dark:border-gray-500 dark:bg-gray-700 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                <template x-for="(category, index) in categories" :key="category.id">
                    <div x-show="openTab === category.id, initTextareas()">
                        <template x-for="(standard, standardIndex) in category.standards" :key="standard.id">
                            <div class="mb-5">
                                <div class="flex items-center gap-x-2">
                                    <button type="button" @click="removeStandard(standardIndex)"
                                        class="rounded-full p-1 text-gray-500 hover:text-red-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m15 9-6 6"></path>
                                            <path d="m9 9 6 6"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" x-model="standard.id "
                                        :name="'categories[' + index + '][standards][' + standardIndex + '][id]'" />
                                    <input type="hidden" x-model="standard.category_id"
                                        :name="'categories[' + index + '][standards][' + standardIndex + '][category_id]'" />
                                    <input type="text" x-model="standard.name"
                                        :name="'categories[' + index + '][standards][' + standardIndex + '][name]'"
                                        class="min-w-52 border-0 border-indigo-800 bg-white p-0 text-lg font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400"
                                        x-bind:style="'width: ' + (standard.name.length + 1) + 'ch;'"
                                        placeholder="Enter Standard Name" />
                                </div>
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="w-[2%]"></th>
                                            <th
                                                class="w-[44%] border border-indigo-800 font-semibold dark:border-gray-400 dark:text-white">
                                                Competencies</th>
                                            <th
                                                class="w-[44%] border border-indigo-800 font-semibold dark:border-gray-400 dark:text-white">
                                                Indicators</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(competency, competencyIndex) in standard.competencies"
                                            :key="competency.id">
                                            <tr>
                                                <td>
                                                    <button type="button"
                                                        @click="removeCompetency(standardIndex, competencyIndex)"
                                                        class="rounded-full text-gray-500 hover:text-red-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <path d="m15 9-6 6"></path>
                                                            <path d="m9 9 6 6"></path>
                                                        </svg>
                                                    </button>
                                                </td>
                                                <td
                                                    class="border border-blue-800 p-2 dark:border-gray-500 dark:text-white">
                                                    <input type="hidden" x-model="competency.id"
                                                        :name="'categories[' + index + '][standards][' + standardIndex +
                                                            '][competencies][' + competencyIndex + '][id]'" />
                                                    <input type="hidden" x-model="competency.standard_id"
                                                        :name="'categories[' + index + '][standards][' + standardIndex +
                                                            '][competencies][' + competencyIndex + '][standard_id]'" />
                                                    <textarea x-model="competency.statement"
                                                        :name="'categories[' + index + '][standards][' + standardIndex +
                                                            '][competencies][' + competencyIndex + '][statement]'"
                                                        class="w-full resize-none overflow-hidden border-0 bg-transparent font-semibold text-indigo-800 focus:ring-0"
                                                        rows="3" placeholder="Enter Competency Statement" style="text-align: justify;">
                                                </textarea>
                                                </td>
                                                <td
                                                    class="border border-blue-800 p-2 dark:border-gray-500 dark:text-white">
                                                    <template
                                                        x-for="(indicator, indicatorIndex) in competency.indicators"
                                                        :key="indicator.id">
                                                        <div class="mb-4 items-center justify-between gap-x-2 md:flex">
                                                            <button type="button"
                                                                @click="removeIndicator(standardIndex, competencyIndex, indicatorIndex)"
                                                                class="rounded-full text-gray-500 hover:text-red-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <circle cx="12" cy="12" r="10">
                                                                    </circle>
                                                                    <path d="m15 9-6 6"></path>
                                                                    <path d="m9 9 6 6"></path>
                                                                </svg>
                                                            </button>
                                                            <input type="hidden" x-model="indicator.id"
                                                                :name="'categories[' + index + '][standards][' +
                                                                    standardIndex + '][competencies][' +
                                                                    competencyIndex + '][indicators][' +
                                                                    indicatorIndex + '][id]'" />
                                                            <input type="hidden" x-model="indicator.competency_id"
                                                                :name="'categories[' + index + '][standards][' +
                                                                    standardIndex + '][competencies][' +
                                                                    competencyIndex + '][indicators][' +
                                                                    indicatorIndex + '][competency_id]'" />
                                                            <input type="text" x-model="indicator.code" readonly
                                                                :name="'categories[' + index + '][standards][' +
                                                                    standardIndex + '][competencies][' +
                                                                    competencyIndex + '][indicators][' +
                                                                    indicatorIndex + '][code]'"
                                                                class="min-w-8 border-0 border-indigo-800 bg-transparent p-0 text-center text-sm font-semibold text-indigo-800 focus:ring-0 dark:border-gray-500 dark:bg-gray-700 dark:text-purple-400"
                                                                x-bind:style="'width: ' + (indicator.code.length + 1) + 'ch;'" />
                                                            <textarea x-model="indicator.assessment"
                                                                :name="'categories[' + index + '][standards][' +
                                                                    standardIndex + '][competencies][' +
                                                                    competencyIndex + '][indicators][' +
                                                                    indicatorIndex + '][assessment]'"
                                                                class="w-[90%] resize-none overflow-hidden border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent pb-0 text-sm font-semibold text-indigo-800 focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0"
                                                                rows="1" placeholder="Enter Indicator Assessment" style="text-align: justify;">
                                                        </textarea>

                                                            <!-- Modal Content -->
                                                            <button type="button" @click="openModal(indicator.id)"
                                                                class="text-gray-500 hover:text-indigo-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500">
                                                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75">
                                                                    </path>
                                                                </svg>
                                                            </button>

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
                                                                    role="dialog" :id="'modal-' + indicator.id">
                                                                    <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                                                                    <header class="flex justify-end">
                                                                        <button type="button"
                                                                            class="inline-flex h-6 w-6 items-center justify-center rounded text-gray-400 transition-colors duration-150 hover:text-gray-700 dark:hover:text-gray-200"
                                                                            aria-label="close" @click="closeModal()">
                                                                            <svg class="h-4 w-4" fill="currentColor"
                                                                                viewBox="0 0 20 20" role="img"
                                                                                aria-hidden="true">
                                                                                <path
                                                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                                    clip-rule="evenodd"
                                                                                    fill-rule="evenodd"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </header>
                                                                    <!-- Modal body -->

                                                                    <!-- Modal title -->
                                                                    <div
                                                                        class="mb-6 flex flex-col gap-y-8 text-gray-500">
                                                                        <h3
                                                                            class="text-lg font-semibold text-indigo-800 dark:text-gray-300">
                                                                            Set Indicator Entry
                                                                            <span x-text="indicator.code"></span>
                                                                        </h3>
                                                                        <div class="flex flex-col gap-y-5">
                                                                            <!-- Modal form -->
                                                                            <div
                                                                                class="flex items-center justify-between gap-x-3">
                                                                                <svg class="size-7"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor"
                                                                                    stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495">
                                                                                    </path>
                                                                                </svg>
                                                                                <select x-model="indicator.entry"
                                                                                    :name="'categories[' + index +
                                                                                        '][standards][' +
                                                                                        standardIndex +
                                                                                        '][competencies][' +
                                                                                        competencyIndex +
                                                                                        '][indicators][' +
                                                                                        indicatorIndex + '][entry]'"
                                                                                    @change="setData($event, indicator)"
                                                                                    class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-3 py-0 font-semibold text-indigo-800 focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                    <option value="Option">Option
                                                                                        ( Yes/No )
                                                                                    </option>
                                                                                    <option value="Digit">Digit ( # )
                                                                                    </option>
                                                                                    <option value="Decimal">Decimal ( .
                                                                                        )
                                                                                    </option>
                                                                                    <option value="Cost">Cost ( $ )
                                                                                    </option>
                                                                                    <option value="Percentage">
                                                                                        Percentage ( % )</option>
                                                                                    <option value="Rate">
                                                                                        Rate ( * )</option>
                                                                                    <option value="Disable">
                                                                                        Disable ( )</option>
                                                                                </select>
                                                                            </div>

                                                                            <div
                                                                                class="flex items-center justify-end gap-x-3">
                                                                                <template
                                                                                    x-if="indicator.entry === 'Rate'">
                                                                                    <select
                                                                                        x-model="indicator.rate_option"
                                                                                        :name="'categories[' + index +
                                                                                            '][standards][' +
                                                                                            standardIndex +
                                                                                            '][competencies][' +
                                                                                            competencyIndex +
                                                                                            '][indicators][' +
                                                                                            indicatorIndex +
                                                                                            '][rate_option]'"
                                                                                        class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-3 py-0 font-semibold text-indigo-800 focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0">
                                                                                        <option hidden value="1-10">
                                                                                            Choose rating scale</option>
                                                                                        <option value="1-10">1-10
                                                                                        </option>
                                                                                        <option value="1-100">1-100
                                                                                        </option>
                                                                                    </select>
                                                                                </template>
                                                                                <template
                                                                                    x-if="indicator.entry === 'Disable'">
                                                                                    <textarea x-model="indicator.disable_text"
                                                                                        :name="'categories[' + index +
                                                                                            '][standards][' +
                                                                                            standardIndex +
                                                                                            '][competencies][' +
                                                                                            competencyIndex +
                                                                                            '][indicators][' +
                                                                                            indicatorIndex +
                                                                                            '][disable_text]'"
                                                                                        class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-3 py-0 font-semibold text-indigo-800 focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0"
                                                                                        placeholder="Enter some text">
                                                                                </textarea>
                                                                                </template>
                                                                            </div>

                                                                            <div
                                                                                class="flex items-start justify-between gap-x-3">
                                                                                <svg class="size-7"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor"
                                                                                    stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z">
                                                                                    </path>
                                                                                </svg>
                                                                                <textarea x-model="indicator.info"
                                                                                    :name="'categories[' + index +
                                                                                        '][standards][' +
                                                                                        standardIndex +
                                                                                        '][competencies][' +
                                                                                        competencyIndex +
                                                                                        '][indicators][' +
                                                                                        indicatorIndex +
                                                                                        '][info]'"
                                                                                    class="w-[90%] border-b-2 border-x-transparent border-b-gray-200 border-t-transparent bg-transparent px-3 py-0 font-semibold text-indigo-800 focus:border-x-transparent focus:border-b-indigo-600 focus:border-t-transparent focus:ring-0"
                                                                                    placeholder="Enter link verification info">
                                                                            </textarea>
                                                                            </div>
                                                                        </div>
                                                                        <footer
                                                                            class="-mx-6 -mb-4 flex flex-row items-center justify-end space-x-6 space-y-0 bg-gray-50 px-6 py-3 dark:bg-gray-800">
                                                                            <button type="button" @click="closeModal"
                                                                                class="text w-full rounded-lg border border-transparent bg-indigo-600 px-5 py-3 text-sm font-semibold leading-5 text-white transition-colors duration-150 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple active:bg-purple-600 sm:w-auto sm:px-4 sm:py-2">
                                                                                Save
                                                                            </button>
                                                                        </footer>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End of modal backdrop -->
                                                            <!-- End Modal Content -->

                                                        </div>
                                                    </template>
                                                    <button type="button"
                                                        @click="addIndicator(standardIndex, competencyIndex)"
                                                        class="w-[90%] rounded bg-green-500 p-1 text-xs font-semibold text-white hover:bg-green-600 dark:bg-blue-500 dark:hover:bg-blue-600">
                                                        Add Indicator
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                        <tr>
                                            <td class="w-[2%]"></td>
                                            <td colspan="3"
                                                class="border border-blue-800 p-2 text-center dark:border-gray-500 dark:text-white">
                                                <button type="button" @click="addCompetency(standardIndex)"
                                                    class="w-full rounded bg-green-500 p-1 text-xs font-semibold text-white hover:bg-green-600 dark:bg-blue-500 dark:hover:bg-blue-600">
                                                    Add Competency
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </div>
                </template>
                <button type="button" @click="addStandard()" x-show="categories.length > 0 && !isOpenTabInvalid()"
                    class="w-full rounded bg-green-500 p-1.5 text-xs font-semibold text-white hover:bg-green-600 dark:bg-blue-500 dark:hover:bg-blue-600">
                    Add Standard
                </button>
                <div x-show="categories.length > 0 && isOpenTabInvalid()"
                    class="flex h-full items-center justify-center text-gray-500">
                    Please choose some tab.
                </div>
                <div x-show="categories.length === 0" class="flex h-full items-center justify-center text-gray-500">
                    No categories available. Please add some tab.
                </div>

            </div>
        </div>

        <div class="flex justify-end">
            <div class="space-x-8">
                <button type="submit" name="action" value="draft"
                    class="inline-flex rounded-md bg-gray-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-600">
                    {{ __('Save as a Draft') }}
                </button>
                <button type="submit" name="action" value="submit"
                    class="inline-flex rounded-md bg-blue-700 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-800">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
