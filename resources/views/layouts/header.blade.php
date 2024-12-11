<header class="z-30 bg-cool-gray-50 transition-all duration-300 ease-in-out dark:bg-gray-800">
    <div class="mx-6 my-4 rounded-sm bg-white px-4 py-2 shadow-md dark:bg-cool-gray-50">
        <div class=" flex items-center justify-between">
            <button id="toggle-sidebar" @click="toggleSideMenu"
                class="hidden rounded-md text-gray-500 hover:shadow-outline-blue focus:shadow-outline-blue lg:block">
                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <!-- Mobile hamburger -->
            <button @click="toggleSideMenuResponsive"
                class="rounded-md text-gray-500 hover:shadow-outline-blue focus:shadow-outline-blue lg:hidden">
                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul class="flex flex-shrink-0 items-center md:space-x-6">
                <!-- Theme toggler -->
                <div class="flex items-end gap-x-4">
                    <li class="flex">
                        <button
                            class="rounded-md text-gray-500 hover:shadow-outline-blue focus:shadow-outline-blue dark:text-yellow-300"
                            @click="toggleTheme" aria-label="Toggle color mode">
                            <template x-if="!dark">
                                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z">
                                    </path>
                                </svg>
                            </template>
                            <template x-if="dark">
                                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </template>
                        </button>
                    </li>
                    <!-- Notifications menu -->
                    <li class="relative">
                        <button
                            class="relative rounded-md align-middle text-gray-500 hover:shadow-outline-blue focus:shadow-outline-blue"
                            @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                            aria-label="Notifications" aria-haspopup="true">
                            <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                            <!-- Notification badge -->
                            <span aria-hidden="true"
                                class="absolute right-0 top-0 inline-block h-3 w-3 -translate-y-1 translate-x-1 transform rounded-full border-2 border-white bg-red-600"></span>
                        </button>
                        <template x-if="isNotificationsMenuOpen">
                            <ul x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                                class="absolute right-0 mt-2 w-56 space-y-2 rounded-md border border-gray-100 bg-white p-2 text-gray-600 shadow-md dark:border-gray-900 dark:bg-gray-900 dark:text-gray-300">
                                <li class="flex">
                                    <a
                                        class="inline-flex w-full items-center justify-between rounded-md px-2 py-1 text-sm font-semibold transition-colors duration-150 hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                        <span>No new notification</span>
                                    </a>
                                </li>
                            </ul>
                        </template>
                    </li>
                </div>
                <!-- Profile menu -->
                <li class="relative">
                    <button @click="toggleProfileMenu"
                        class="hidden items-center space-x-1 rounded-md border-2 border-gray-500 px-2 py-1 text-xs font-medium transition duration-500 ease-in-out hover:bg-gray-500 hover:text-cool-gray-50 md:inline-flex">
                        <div>{{ $userRole }}</div>
                        <div>
                            <template x-if="isProfileMenuOpen">
                                <svg class="h-4 w-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M14.707 12.707a1 1 0 01-1.414 1.414L10 10.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </template>
                            <template x-if="!isProfileMenuOpen">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </template>
                        </div>
                    </button>
                    <template x-if="isProfileMenuOpen">
                        <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" @click.away="closeProfileMenu"
                            @keydown.escape="closeProfileMenu"
                            class="absolute right-0 mt-2 w-44 space-y-2 rounded-md bg-white p-2 text-gray-900 shadow-md dark:bg-cool-gray-50">
                            <li class="flex">
                                <a class="inline-flex w-full items-center rounded-md px-2 py-1 text-sm font-semibold transition-colors duration-150 hover:bg-gray-300"
                                    href="/profile">
                                    <svg class="mr-3 h-4 w-4" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li class="flex">
                                <a class="inline-flex w-full items-center rounded-md px-2 py-1 text-sm font-semibold transition-colors duration-150 hover:bg-gray-300"
                                    href="/edit-password">
                                    <svg class="mr-3 h-4 w-4" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Change Password</span>
                                </a>
                            </li>

                            @if (Auth::user()->roles->count() > 1)
                                @foreach (Auth::user()->roles->where('name', '!=', $userRole) as $role)
                                    <li class="flex">
                                        <form method="POST" action="/roles"
                                            class="inline-flex w-full items-center rounded-md px-2 py-1 text-sm font-semibold transition-colors duration-150 hover:bg-gray-300">
                                            @csrf
                                            <input value="{{ $role->name }}" type="hidden" name="role">
                                            <button type="submit" class="inline-flex w-full items-center">
                                                <svg class="mr-3 h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    stroke="currentColor">
                                                    <path d="M18 10L21 7M21 7L18 4M21 7H7M6 14L3 17M3 17L6 20M3 17H17">
                                                    </path>
                                                </svg>
                                                <span>Switch to {{ $role->name }}</span>
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            @endif


                            <li class="flex">
                                <form method="POST" action="/logout"
                                    class="inline-flex w-full items-center rounded-md px-2 py-1 text-sm font-semibold transition-colors duration-150 hover:bg-gray-300">
                                    @csrf
                                    <button type="submit" class="inline-flex w-full items-center">
                                        <svg class="mr-3 h-4 w-4" aria-hidden="true" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9">
                                            </path>
                                        </svg>
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        </div>
    </div>
</header>
