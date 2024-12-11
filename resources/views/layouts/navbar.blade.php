<!-- Desktop sidebar -->
<aside :class="{ 'slide': isSideMenuOpen }"
    class="z-40 hidden min-h-screen w-60 bg-white font-medium transition-all duration-300 ease-in-out dark:bg-gray-900 lg:block">
    <div class="border-b border-solid border-blue-800 py-2 text-center">
        <table>
            <tr>
                <td class="w-[10%]">
                    <img class="ml-8 h-full w-full rounded-md p-1 dark:bg-cool-gray-50"
                        src="{{ asset('images/Logo ITK.png') }}" alt="Logo ITK">
                </td>
                <td class="text-xl text-blue-800 dark:text-cool-gray-50">
                    <h5><b>SIM AMI ITK</b></h5>
                </td>
            </tr>
        </table>
    </div>
    <ul class="max-h-full overflow-y-auto scrollbar-thin">
        <li
            class="{{ Request::is('dashboard') ? 'font-bold text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:bg-cool-gray-50 dark:hover:bg-gray-800' }}">
            <a class="flex w-full items-center justify-between px-1 py-3 pl-8" href="/dashboard">
                <div class="flex items-center gap-x-5">
                    <i class="fa-solid fa-chart-column w-5 text-center"></i>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        <li
            class="{{ Request::is('calendar*') ? 'font-bold text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:bg-cool-gray-50 dark:hover:bg-gray-800' }}">
            <a href="/calendar" class="flex w-full items-center justify-between px-1 py-3 pl-8">
                <div class="flex items-center gap-x-5">
                    <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z">
                        </path>
                    </svg>
                    <span>Calendar</span>
                </div>
            </a>
        </li>

        <li
            class="{{ Request::is('forms*') ? 'font-bold text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:bg-cool-gray-50 dark:hover:bg-gray-800' }}">
            <a class="flex w-full items-center justify-between px-1 py-3 pl-8" href="/forms">
                <div class="flex items-center gap-x-5">
                    <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z">
                        </path>
                    </svg>
                    <span>Forms</span>
                </div>
            </a>
        </li>

        @if ($userRole == 'PJM')
            <li
                class="{{ Request::is('documents*') ? 'font-bold text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:bg-cool-gray-50 dark:hover:bg-gray-800' }}">
                <a class="flex w-full items-center justify-between px-1 py-3 pl-8" href="/documents">
                    <div class="flex items-center gap-x-5">
                        <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776">
                            </path>

                        </svg>
                        <span>Documents</span>
                    </div>
                </a>
            </li>

            <li
                class="{{ Request::is(['users*', 'units*', 'departments*', 'logs*']) ? 'font-bold text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:bg-cool-gray-50 dark:hover:bg-gray-800' }}">
                <button @click="togglePagesMenu" class="flex w-full items-center justify-between px-1 py-3 pl-8">
                    <div class="flex items-center gap-x-5">
                        <i class="fa-solid fa-database w-5 text-center"></i>
                        <span>Data Management</span>
                    </div>
                    <template x-if="isPagesMenuOpen">
                        <svg class="w-5 text-center" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.707 12.707a1 1 0 01-1.414 1.414L10 10.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </template>
                    <template x-if="!isPagesMenuOpen">
                        <svg class="w-5 text-center" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </template>
                </button>
                <template x-if="isPagesMenuOpen">
                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                        x-transition:leave="transition-all ease-in-out duration-300"
                        x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0"
                        class="space-y-2 overflow-hidden px-20 py-3 font-medium dark:text-gray-400">
                        <li
                            class="{{ Request::is('departments*') ? 'text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:text-blue-800' }}">
                            <a class="flex w-full items-center justify-between" href="/departments">
                                <div class="flex items-center gap-x-4">
                                    <svg class="w-5 text-center" aria-hidden="true" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z">
                                        </path>
                                    </svg>
                                    <span>Departments</span>
                                </div>
                            </a>
                        </li>
                        <li
                            class="{{ Request::is('units*') ? 'text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:text-blue-800' }}">
                            <a class="flex w-full items-center justify-between" href="/units">
                                <div class="flex items-center gap-x-4">
                                    <svg class="w-5 text-center" aria-hidden="true" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                        </path>
                                    </svg>
                                    <span>Units</span>
                                </div>
                            </a>
                        </li>
                        <li
                            class="{{ Request::is('users*') ? 'text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:text-blue-800' }}">
                            <a class="flex w-full items-center justify-between" href="/users">
                                <div class="flex items-center gap-x-4">
                                    <svg class="w-5 text-center" aria-hidden="true" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z">
                                        </path>
                                    </svg>
                                    <span>Users</span>
                                </div>
                            </a>
                        </li>
                        <li
                            class="{{ Request::is('logs*') ? 'text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:text-blue-800' }}">
                            <a class="flex w-full items-center justify-between" href="/logs">
                                <div class="flex items-center gap-x-4">
                                    <svg class="w-5 text-center" aria-hidden="true" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                                        </path>
                                    </svg>
                                    <span>Logs</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </template>
            </li>
        @endif

        {{-- @if ($userRole == 'Auditee')
            <li
                class="{{ Request::is('evaluations*') ? 'font-bold text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:bg-cool-gray-50 dark:hover:bg-gray-800' }}">
                <a class="flex w-full items-center justify-between px-1 py-3 pl-8" href="/evaluations">
                    <div class="flex items-center gap-x-5">
                        <i class="fas fa-marker w-5 text-center"></i>
                        <span>Evaluations</span>
                    </div>
                </a>
            </li>
        @endif

        @if ($userRole == 'Auditor')
            <li
                class="{{ Request::is('audits*') ? 'font-bold text-blue-800 dark:text-cool-gray-50 bg-cool-gray-50 dark:bg-gray-800' : 'text-gray-500 hover:bg-cool-gray-50 dark:hover:bg-gray-800' }}">
                <a class="flex w-full items-center justify-between px-1 py-3 pl-8" href="/audits">
                    <div class="flex items-center gap-x-5">
                        <i class="fa-solid fa-scroll w-5"></i>
                        <span>Audits</span>
                    </div>
                </a>
            </li>
        @endif --}}
    </ul>
</aside>

<!-- Mobile sidebar -->
<!-- Backdrop -->
<div x-show="isSideMenuOpenResponsive" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
</div>
<aside
    class="mt-18 fixed inset-y-0 z-30 mt-[72px] min-h-screen w-60 flex-shrink-0 overflow-hidden bg-cool-gray-50 scrollbar-thin dark:bg-gray-900 dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800"
    x-show="isSideMenuOpenResponsive" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenuResponsive"
    @keydown.escape="closeSideMenuResponsive">
    <div class="px-8 py-4 text-gray-500 dark:text-gray-400">
        <div class="text-lg font-bold text-gray-800 dark:text-gray-200">
            {{ $userRole }}
        </div>
        <a class="text-sm text-gray-800 dark:text-gray-200" href="/profile">
            {{ Auth::user()->email }}
        </a>
    </div>
    <div class="max-h-full overflow-y-auto text-gray-500 scrollbar-thin dark:text-gray-400">
        <ul class="flex flex-col">
            <li class="relative px-6 py-2">
                <span
                    class="{{ Request::is('dashboard') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                <a class="{{ Request::is('dashboard') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                    href="/dashboard">
                    <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            <li class="relative px-6 py-2">
                <span
                    class="{{ Request::is('calendar*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                <a class="{{ Request::is('calendar*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                    href="/calendar">
                    <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z">
                        </path>
                    </svg>
                    <span class="ml-4">Calendar</span>
                </a>
            </li>

            <li class="relative px-6 py-2">
                <span
                    class="{{ Request::is('forms*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                <a class="{{ Request::is('forms*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                    href="/forms">
                    <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="ml-4">Forms</span>
                </a>
            </li>

            @if ($userRole == 'PJM')
                <li class="relative px-6 py-2">
                    <span
                        class="{{ Request::is('documents*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                    <a class="{{ Request::is('documents*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                        href="/documents">
                        <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-4">Documents</span>
                    </a>
                </li>

                {{-- <li class="relative px-6 py-2">
                    <span
                        class="{{ Request::is('users*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                    <a class="{{ Request::is('users*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                        href="/users">
                        <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z">
                            </path>
                        </svg>
                        <span class="ml-4">Departments</span>
                    </a>
                </li> --}}

                <li class="relative px-6 py-2">
                    <span
                        class="{{ Request::is('users*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                    <a class="{{ Request::is('users*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                        href="/users">
                        <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                            </path>
                        </svg>
                        <span class="ml-4">Units</span>
                    </a>
                </li>

                <li class="relative px-6 py-2">
                    <span
                        class="{{ Request::is('users*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                    <a class="{{ Request::is('users*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                        href="/users">
                        <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z">
                            </path>
                        </svg>
                        <span class="ml-4">Users</span>
                    </a>
                </li>

                <li class="relative px-6 py-2">
                    <span
                        class="{{ Request::is('logs*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                    <a class="{{ Request::is('logs*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                        href="/logs">
                        <svg class="w-5 text-center" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z">
                            </path>
                        </svg>
                        <span class="ml-4">Logs</span>
                    </a>
                </li>
            @endif

            {{-- @if ($userRole == 'Auditee')
                <li class="relative px-6 py-2">
                    <span
                        class="{{ Request::is('evaluations*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                    <a class="{{ Request::is('evaluations*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                        href="/evaluations">
                        <i class="fas fa-marker w-5 text-center"></i>
                        <span class="ml-4">Evaluations</span>
                    </a>
                </li>
            @endif

            @if ($userRole == 'Auditor')
                <li class="relative px-6 py-2">
                    <span
                        class="{{ Request::is('audits*') ? '' : 'hidden' }} absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-blue-800 dark:bg-indigo-600"></span>
                    <a class="{{ Request::is('audits*') ? 'font-semibold text-blue-800 dark:text-indigo-500' : 'hover:text-blue-800 dark:hover:text-gray-100' }} inline-flex w-full items-center text-sm font-semibold transition-colors duration-150"
                        href="/audits">
                        <i class="fas fa-marker w-5 text-center"></i>
                        <span class="ml-4">Audits</span>
                    </a>
                </li>
            @endif --}}

            <ul class="space-y-2 px-8 py-2">

                @if (Auth::user()->roles->count() > 1)
                    @foreach (Auth::user()->roles->where('name', '!=', $userRole) as $role)
                        <li class="relative">
                            <form method="POST" action="/roles"
                                class="inline-flex w-full items-center rounded-md px-2 py-1 text-xs font-semibold transition-colors duration-150 hover:bg-gray-300">
                                @csrf
                                <input value="{{ $role->name }}" type="hidden" name="role">
                                <button type="submit" class="inline-flex w-full items-center">
                                    <svg class="mr-3 h-4 w-4" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" stroke="currentColor">
                                        <path d="M18 10L21 7M21 7L18 4M21 7H7M6 14L3 17M3 17L6 20M3 17H17">
                                        </path>
                                    </svg>
                                    <span>Switch to {{ $role->name }}</span>
                                </button>
                            </form>
                        </li>
                    @endforeach
                @endif

                <li class="relative">
                    <a class="inline-flex w-full items-center rounded-md px-2 py-1 text-xs font-semibold transition-colors duration-150 hover:bg-gray-300"
                        href="/edit-password">
                        <svg class="mr-3 h-4 w-4" aria-hidden="true" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Change Password</span>
                    </a>
                </li>

                <li class="relative">
                    <form method="POST" action="{{ route('logout') }}"
                        class="inline-flex w-full items-center rounded-md px-2 py-1 text-xs font-semibold transition-colors duration-150 hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                        @csrf
                        <button type="submit" class="inline-flex w-full items-center">
                            <svg class="mr-3 h-4 w-4" aria-hidden="true" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15">
                                </path>
                            </svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </li>
            </ul>
        </ul>
    </div>
</aside>
