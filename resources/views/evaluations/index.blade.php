<x-app-layout>
    <div class="mb-4 flex items-center justify-between">
        <ol class="inline-flex items-center text-lg">
            <li>
                <div class="flex items-center">
                    <a class="mx-1 font-medium text-blue-800 dark:text-cool-gray-50">
                        Evaluations
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
                        <th class="px-16 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $form)
                        <tr
                            class="border-b bg-white text-center hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:text-cool-gray-50">
                            <td class="px-4 py-2">{{ $loop->iteration . '.' }}</td>
                            <td class="px-12 py-2 text-left">{{ $form->unit->name }}</td>
                            <td class="px-16 py-2 text-left">{{ optional($form->document)->name }}</td>
                            <td class="grid gap-y-2 px-16 py-2 xl:block xl:space-x-2">
                                <a href="{{ route('evaluations.edit', $form->id) }}"
                                    class="inline-block rounded border border-green-400 px-3 py-1 text-sm font-medium text-green-400 transition hover:bg-green-400 hover:text-white">
                                    <i class="fa fa-edit mr-1"></i>
                                    Isi Laporan
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

{{-- <div class="flex min-h-screen flex-col justify-center bg-transparent">
    <div class="relative w-2/3 text-center">
        <div
            class="absolute inset-0 -skew-y-6 transform bg-gradient-to-r from-cyan-400 to-sky-500 shadow-lg sm:-rotate-6 sm:skew-y-0 sm:rounded-3xl">
        </div>
        <div class="relative bg-white shadow-lg sm:rounded-3xl sm:p-16">

            <div class="mx-auto max-w-md">
                <div>
                    <h1 class="text-2xl font-semibold">Login</h1>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="space-y-4 py-8 text-base leading-6 text-gray-700 sm:text-lg sm:leading-7">
                        <div class="relative">
                            <input autocomplete="off" id="email" name="email" type="text"
                                class="focus:borer-rose-600 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none"
                                placeholder="Email address" />
                            <label for="email"
                                class="peer-placeholder-shown:text-gray-440 absolute -top-3.5 left-0 text-sm text-gray-600 transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-gray-600">Email
                                Address</label>
                        </div>
                        <div class="relative">
                            <input autocomplete="off" id="password" name="password" type="password"
                                class="focus:borer-rose-600 peer h-10 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none"
                                placeholder="Password" />
                            <label for="password"
                                class="peer-placeholder-shown:text-gray-440 absolute -top-3.5 left-0 text-sm text-gray-600 transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-gray-600">Password</label>
                        </div>
                        <div class="relative">
                            <button class="rounded-md bg-cyan-500 px-2 py-1 text-white">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex w-full justify-center">
                <button
                    class="flex items-center rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-medium text-gray-800 shadow-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <svg class="mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px"
                        viewBox="-0.5 0 48 48" version="1.1">
                        <title>Google-color</title>
                        <desc>Created with Sketch.</desc>
                        <defs> </defs>
                        <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Color-" transform="translate(-401.000000, -860.000000)">
                                <g id="Google" transform="translate(401.000000, 860.000000)">
                                    <path
                                        d="M9.82727273,24 C9.82727273,22.4757333 10.0804318,21.0144 10.5322727,19.6437333 L2.62345455,13.6042667 C1.08206818,16.7338667 0.213636364,20.2602667 0.213636364,24 C0.213636364,27.7365333 1.081,31.2608 2.62025,34.3882667 L10.5247955,28.3370667 C10.0772273,26.9728 9.82727273,25.5168 9.82727273,24"
                                        id="Fill-1" fill="#FBBC05"> </path>
                                    <path
                                        d="M23.7136364,10.1333333 C27.025,10.1333333 30.0159091,11.3066667 32.3659091,13.2266667 L39.2022727,6.4 C35.0363636,2.77333333 29.6954545,0.533333333 23.7136364,0.533333333 C14.4268636,0.533333333 6.44540909,5.84426667 2.62345455,13.6042667 L10.5322727,19.6437333 C12.3545909,14.112 17.5491591,10.1333333 23.7136364,10.1333333"
                                        id="Fill-2" fill="#EB4335"> </path>
                                    <path
                                        d="M23.7136364,37.8666667 C17.5491591,37.8666667 12.3545909,33.888 10.5322727,28.3562667 L2.62345455,34.3946667 C6.44540909,42.1557333 14.4268636,47.4666667 23.7136364,47.4666667 C29.4455,47.4666667 34.9177955,45.4314667 39.0249545,41.6181333 L31.5177727,35.8144 C29.3995682,37.1488 26.7323182,37.8666667 23.7136364,37.8666667"
                                        id="Fill-3" fill="#34A853"> </path>
                                    <path
                                        d="M46.1454545,24 C46.1454545,22.6133333 45.9318182,21.12 45.6113636,19.7333333 L23.7136364,19.7333333 L23.7136364,28.8 L36.3181818,28.8 C35.6879545,31.8912 33.9724545,34.2677333 31.5177727,35.8144 L39.0249545,41.6181333 C43.3393409,37.6138667 46.1454545,31.6490667 46.1454545,24"
                                        id="Fill-4" fill="#4285F4"> </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <span>Continue with Google</span>
                </button>
            </div>

        </div>
    </div>
</div> --}}
