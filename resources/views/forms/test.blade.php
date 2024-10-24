<ul class="space-y-3">
    <li>
        <input value="Pimpinan" readonly name="positions[]"
            class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
    </li>
    <li>
        <input value="PIC" readonly name="positions[]"
            class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
    </li>
    <template x-for="(item, itemIndex) in auditees || []" :key="item">
        <li>
            <input :value="'PIC ' + item.id" readonly name="positions[]"
                class="w-full items-center rounded-s-lg border border-gray-300 bg-gray-100 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-700" />
        </li>
    </template>
</ul>
<ul class="space-y-3">
    <li class="flex items-center">
        <div class="relative flex items-center">
            <input type="text" id="auditeeName-0" @input="searchUsers('auditee', 0)" name="user_names[]"
                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                placeholder="Search User" />
            <input type="hidden" id="auditeeUsername-0" name="user_usernames[]" />
            <input type="hidden" id="auditeeEmail-0" name="user_emails[]" />
            <div x-show="showResults && currentRole === 'auditee' && currentItem === 0"
                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                <template x-for="user in results" :key="user.PE_Email">
                    <div @click="selectUser(user, 'auditee', 0)"
                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                        <span x-text="user.PE_Nama"></span>
                    </div>
                </template>
                <div x-show="results.length === 0" class="px-4 py-2 text-sm text-gray-500">
                    No users found
                </div>
            </div>
        </div>
    </li>
    <li class="flex items-center">
        <div class="relative flex items-center">
            <input type="text" id="auditeeName-1" @input="searchUsers('auditee', 1)" name="user_names[]"
                class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                placeholder="Search User" />
            <input type="hidden" id="auditeeUsername-1" name="user_usernames[]" />
            <input type="hidden" id="auditeeEmail-1" name="user_emails[]" />
            <div x-show="showResults && currentRole === 'auditee' && currentItem === 1"
                class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                <template x-for="user in results" :key="user.PE_Email">
                    <div @click="selectUser(user, 'auditee', 1)"
                        class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                        <span x-text="user.PE_Nama"></span>
                    </div>
                </template>
                <div x-show="results.length === 0" class="px-4 py-2 text-sm text-gray-500">
                    No users found
                </div>
            </div>
        </div>
    </li>
    <template x-for="(item, itemIndex) in auditees || []" :key="item">
        <li class="flex items-center">
            <div class="relative flex items-center">
                <input type="text" :id="'auditeeName-' + item.id" @input="searchUsers('auditee', item.id)"
                    name="user_names[]"
                    class="w-full rounded-e-lg border border-s-2 border-gray-300 border-s-gray-50 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:border-s-gray-700 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
                    placeholder="Search User" />
                <input type="hidden" :id="'auditeeUsername-' + item.id" name="user_usernames[]" />
                <input type="hidden" :id="'auditeeEmail-' + item.id" name="user_emails[]" />
                <div x-show="showResults && currentRole === 'auditee' && currentItem === item.id"
                    class="absolute top-full z-50 mt-1 max-h-72 w-full overflow-hidden overflow-y-auto rounded-lg border border-gray-200 bg-white [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar]:w-2">
                    <template x-for="user in results" :key="user.PE_Email">
                        <div @click="selectUser(user, 'auditee', item.id)"
                            class="cursor-pointer rounded-lg px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                            <span x-text="user.PE_Nama"></span>
                        </div>
                    </template>
                    <div x-show="results.length === 0" class="px-4 py-2 text-sm text-gray-500">
                        No users found
                    </div>
                </div>
                <button type="button" @click="removeItem('auditees', itemIndex)"
                    class="ml-2 flex cursor-pointer items-center gap-x-2 rounded text-red-500 hover:text-red-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:border-purple-500 dark:hover:text-gray-200">
                    <svg class="size-4 shrink-0 rounded-full" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 12h8"></path>
                    </svg>
                </button>
            </div>
        </li>
    </template>
    <div class="flex items-center justify-end">
        <button type="button" @click="addItem('auditee')"
            class="flex cursor-pointer items-center rounded text-green-400 hover:text-green-500 dark:bg-gray-700 dark:text-gray-400 dark:hover:border-purple-500 dark:hover:text-gray-200">
            <span>Add Auditee</span>
            <svg class="size-4 ml-2 shrink-0 rounded-full" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10">
                </circle>
                <path d="M12 8v8"></path>
                <path d="M8 12h8"></path>
            </svg>
        </button>
    </div>
</ul>

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
            otherAccesses: {!! json_encode($formAccesses->filter(fn($item) => Str::startsWith($item->position, 'PIC '))->toArray()) !!},
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
                if (!this[role]) {
                    this[role] = [];
                }
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
