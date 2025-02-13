<x-app-layout>
    <div x-data="user()" class="flex h-full w-full flex-col gap-y-1 font-semibold">
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
                <li class="hidden xl:block">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-width="2" viewBox="0 0 6 10">
                        <path d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li class="hidden xl:block">Report</li>
            </ol>
        </div>

        @if ($form->signing && Storage::exists("public/" . $form->signing))
            <embed class="rounded-sm" src="{{ Storage::url($form->signing) }}#toolbar=0" type="application/pdf"
                width="100%" height="650px" class="rounded-lg border">
        @else
            <div
                class="w-full h-[85%] overflow-y-auto scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                <div class="flex h-full items-center justify-center">
                    <p class="font-semibold text-red-500">File tidak ditemukan.</p>
                </div>
            </div>
        @endif

        <div class="flex justify-between py-2">
            <a href="/forms"
                class="rounded-md bg-gray-500 px-4 py-2 text-xs uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:shadow-outline-gray">
                {{ __('Back') }}
            </a>
        </div>
    </div>
</x-app-layout>
