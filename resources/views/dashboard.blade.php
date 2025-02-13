<x-app-layout>
    <div class="space-y-8 font-semibold">
        <div>
            <h2 class="text-2xl font-semibold text-blue-800 dark:text-gray-200">
                Tahapan AMI
            </h2>
            <div class="flex w-full max-w-4xl flex-col items-stretch p-2 sm:h-56 sm:flex-row sm:overflow-hidden">
                @php
                    $colors = ['red-500', 'yellow-300', 'green-400', 'blue-500', 'purple-400'];
                @endphp
                @foreach ($stages as $stage)
                    <form action="{{ route('stages.update', $stage->id) }}" method="POST"
                        class="pane bg-{{ $colors[$loop->index % count($colors)] }} relative m-2 flex min-h-14 min-w-14 flex-grow cursor-pointer items-start justify-center overflow-hidden rounded-3xl text-gray-200 transition-all duration-700 ease-in-out">
                        @csrf
                        @method('PUT')
                        <textarea {{ $userRole !== 'PJM' ? 'disabled' : '' }} name="description"
                            class="m-2 hidden w-full resize-none overflow-hidden border-0 bg-transparent font-semibold placeholder-gray-200 focus:ring-0"
                            rows="5" placeholder="Deskripsi Tahapan Audit" style="text-align: justify;" type="text"
                            name="input_{{ $stage->id }}">{{ $stage->description }}</textarea>

                        <div id="stage"
                            class="absolute bottom-0 z-20 m-2 flex items-center gap-x-2 transition-all duration-700 ease-in-out">
                            <div
                                class="text-{{ $colors[$loop->index % count($colors)] }} flex h-10 w-10 items-center justify-center rounded-full bg-gray-800">
                                <i class="fa-solid fa-{{ $stage->id }}"></i>
                            </div>
                            <div id="title" class="content hidden items-center justify-between gap-x-32">
                                <div class="translate-x-8 transform font-bold opacity-0 transition-all duration-700">
                                    {{ $stage->name }}
                                </div>
                                @if ($userRole == 'PJM')
                                    <button>
                                        Submit
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>

        @if ($userRole == 'PJM')
            <div>
                <h2 class="text-2xl font-semibold text-blue-800 dark:text-gray-200">
                    Users
                </h2>
                <div
                    class="max-h-56 w-full overflow-y-auto rounded-sm scrollbar-thin dark:scrollbar-track-gray-500 dark:scrollbar-thumb-gray-800">
                    <table class="h-full w-full bg-white dark:bg-gray-800">
                        <thead class="sticky top-0 z-10">
                            <tr class="border-b bg-blue-800 text-cool-gray-50">
                                <th class="py-2">#</th>
                                <th>User</th>
                                <th>Contact</th>
                                <th>Role</th>
                                <th>Last seen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <td class="px-2 text-center">{{ $loop->iteration . '.' }}</td>
                                    <td class="whitespace-nowrap p-3">
                                        <div class="flex items-center gap-3">
                                            <div class="relative h-10 w-10">
                                                <img class="h-full w-full rounded-full object-cover"
                                                    src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random"
                                                    alt="" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner"
                                                    aria-hidden="true">
                                                </div>
                                            </div>
                                            <div>
                                                <h1>{{ $user->name }}{{ Auth::id() === $user->id ? ' (Anda)' : '' }}
                                                </h1>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $user->contact }}</td>
                                    <td>
                                        <div class="flex flex-wrap items-center justify-center gap-1 py-2 text-xs">
                                            @foreach ($user->getRoleNames() as $role)
                                                @if ($role == 'PJM')
                                                    <span
                                                        class="rounded-full bg-green-200 px-3 py-1 leading-tight text-green-700 dark:bg-green-700 dark:text-green-200">
                                                        {{ $role }}
                                                    </span>
                                                @elseif ($role == 'Auditor')
                                                    <span
                                                        class="rounded-full bg-yellow-200 px-3 py-1 leading-tight text-yellow-500 dark:bg-yellow-400 dark:text-yellow-200">
                                                        {{ $role }}
                                                    </span>
                                                @elseif ($role == 'Auditee')
                                                    <span
                                                        class="rounded-full bg-red-200 px-3 py-1 leading-tight text-red-700 dark:bg-red-700 dark:text-red-200">
                                                        {{ $role }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="rounded-full bg-gray-200 px-3 py-1 leading-tight text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                                        {{ $role }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-2 text-center">
                                        @if ($user->last_seen && $user->last_seen >= now()->subMinutes(3))
                                            <span
                                                class="rounded-full bg-teal-200 px-3 py-1 text-teal-500 dark:bg-teal-400 dark:text-teal-100">
                                                Online
                                            </span>
                                        @elseif ($user->last_seen)
                                            {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
                                        @else
                                            <span class="text-gray-600 dark:text-gray-400">Tidak pernah terlihat</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Charts -->
        <div>
            <h2 class="text-2xl font-semibold text-blue-800 dark:text-gray-200">
                Charts
            </h2>
            <div class="mb-8 grid gap-6 md:grid-cols-2">
                <!-- Doughnut/Pie chart -->
                <div class="shadow-xs min-w-0 rounded-lg bg-white p-4 dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Ketepatan Waktu Pengumpulan Ketercapaian Standar
                    </h4>
                    <canvas id="pie"></canvas>
                    <div class="mt-4 flex justify-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <!-- Chart legend -->
                        <div class="flex items-center">
                            <span class="mr-1 inline-block h-3 w-3 rounded-full bg-red-500"></span>
                            <span>Tidak tepat waktu</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-1 inline-block h-3 w-3 rounded-full bg-cyan-500"></span>
                            <span>Tepat waktu</span>
                        </div>
                    </div>
                </div>
                <!-- Lines chart -->
                {{-- <div class="shadow-xs min-w-0 rounded-lg bg-white p-4 dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Lines
                    </h4>
                    <canvas id="line"></canvas>
                    <div class="mt-4 flex justify-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <!-- Chart legend -->
                        <div class="flex items-center">
                            <span class="mr-1 inline-block h-3 w-3 rounded-full bg-teal-500"></span>
                            <span>Organic</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-1 inline-block h-3 w-3 rounded-full bg-purple-600"></span>
                            <span>Paid</span>
                        </div>
                    </div>
                </div> --}}
                <!-- Bars chart -->
                <div class="shadow-xs min-w-0 rounded-lg bg-white p-4 dark:bg-gray-800">
                    <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                        Ketercapaian standar
                    </h4>
                    <canvas id="bars"></canvas>
                    <div class="mt-4 flex justify-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <!-- Chart legend -->
                        <div class="flex items-center">
                            <span class="mr-1 inline-block h-3 w-3 rounded-full bg-teal-500"></span>
                            <span>Standar</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-1 inline-block h-3 w-3 rounded-full bg-purple-600"></span>
                            <span>Tercapai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const panes = document.querySelectorAll('.pane');
        let activePaneIndex = 0; // Track index of currently active pane

        panes.forEach((pane, index) => {
            pane.addEventListener('click', () => {
                // Ambil input dari pane yang sedang aktif sebelumnya dan sembunyikan
                const previousInput = panes[activePaneIndex].querySelector('textarea');
                const previousStage = panes[activePaneIndex].querySelector('#stage');
                const previousTitle = panes[activePaneIndex].querySelector('#title');
                previousInput.classList.add('hidden'); // Sembunyikan input dari pane sebelumnya
                previousStage.classList.remove('left-0', 'ml-3'); // Sembunyikan input dari pane sebelumnya
                previousTitle.classList.add('hidden'); // Sembunyikan input dari pane sebelumnya
                previousTitle.classList.remove('flex');

                // Hapus class 'active' dari pane sebelumnya
                panes[activePaneIndex].classList.remove('active');

                // Set pane yang diklik sebagai pane aktif yang baru
                activePaneIndex = index;

                // Tampilkan input dari pane yang baru diklik
                const currentInput = pane.querySelector('textarea');
                const currentStage = pane.querySelector('#stage');
                const currentTitle = pane.querySelector('#title');
                currentInput.classList.remove('hidden'); // Tampilkan input dari pane yang diklik
                currentStage.classList.add('left-0', 'ml-3'); // Tampilkan input dari pane yang diklik
                currentTitle.classList.remove('hidden'); // Tampilkan input dari pane yang diklik
                currentTitle.classList.add('flex');

                // Tambahkan class 'active' ke pane yang baru diklik
                pane.classList.add('active');
            });
        });

    </script>
</x-app-layout>
<script src="{{ asset('js/charts-lines.js') }}" defer></script>
<script src="{{ asset('js/charts-pie.js') }}" defer></script>
<script src="{{ asset('js/charts-bars.js') }}" defer></script>
<script>
    window.chartData = {
        tepatWaktu: {{ $tepatWaktu }},
        tidakTepatWaktu: {{ $tidakTepatWaktu }}
    };

    var categoryPercentages = @json(array_values($categoryPercentages));
</script>