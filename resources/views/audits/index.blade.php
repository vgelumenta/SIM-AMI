<x-app-layout>
    <div class="mb-4 flex items-center justify-between">
        <ol class="inline-flex items-center text-lg">
            <li>
                <div class="flex items-center">
                    <a class="mx-1 font-medium text-blue-800 dark:text-cool-gray-50">
                        Audits
                    </a>
                </div>
            </li>
        </ol>
        <div class="flex items-center">
        </div>
    </div>

    <div
        class="h-[545px] overflow-auto rounded-sm scrollbar-thin dark:scrollbar-track-gray-400 dark:scrollbar-thumb-gray-700">
        @if ($forms->count())
            <table class="whitespace-no-wrap w-full">
                <thead>
                    <tr class="sticky top-0 bg-blue-800 text-cool-gray-50">
                        <th class="px-4 py-2">#</th>
                        <th class="px-12 py-2 text-left">Forms Name</th>
                        <th class="px-16 py-2 text-left">Forms Name</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        <tr
                            class="border-b bg-white text-center hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:text-cool-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration . '.' }}</td>
                            <td class="px-12 py-2 text-left">{{ $form->unit->name }}</td>
                            <td class="px-16 py-2 text-left">{{ $form->document->name }}</td>
                            <td class="grid gap-y-2 px-16 py-2 xl:block xl:space-x-2">
                                <a href="{{ route('audits.edit', $form->id) }}"
                                    class="inline-block rounded border border-green-400 px-3 py-1 text-sm font-medium text-green-400 transition hover:bg-green-400 hover:text-white">
                                    <i class="fa fa-edit mr-1"></i>
                                    Periksa Laporan
                                </a>
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
