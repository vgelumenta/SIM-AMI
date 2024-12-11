<div id="toast-danger"
    class="{{ $errors->any() ? 'flex' : 'hidden' }} absolute end-4 top-4 z-50 max-w-xs items-center gap-x-3 rounded-lg border border-red-400 bg-white p-1.5 text-red-500 shadow dark:bg-gray-800 dark:text-gray-400">
    <div
        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-red-200 dark:bg-red-800 dark:text-red-200">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
        </svg>
    </div>
    <div id="message" class="overflow-hidden truncate whitespace-nowrap text-sm font-semibold">
        {{ $errors->first() }}
    </div>
    <button type="button" onclick="document.getElementById('toast-danger').classList.add('hidden');"
        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg bg-white text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white">
        <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-linecap="round"
            stroke-linejoin="round" viewBox="0 0 14 14">
            <path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
<div id="toast-success"
    class="{{ session('success') ? 'flex' : 'hidden' }} absolute end-4 top-4 z-50 max-w-xs items-center gap-x-3 rounded-lg border border-green-400 bg-white p-1.5 text-green-400 shadow dark:bg-gray-800 dark:text-gray-400">
    <div
        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-green-200 dark:bg-red-800 dark:text-red-200">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
        </svg>
    </div>
    <div id="message" class="overflow-hidden truncate whitespace-nowrap text-sm font-semibold">
        {{ session('success') }}
    </div>
    <button type="button" onclick="document.getElementById('toast-success').classList.add('hidden');"
        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg bg-white text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white">
        <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-linecap="round"
            stroke-linejoin="round" viewBox="0 0 14 14">
            <path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
<div id="toast-warning"
    class="absolute end-4 top-4 z-50 hidden max-w-xs items-center gap-x-3 rounded-lg border border-yellow-200 bg-white p-1.5 text-yellow-300 shadow dark:bg-gray-800 dark:text-gray-400">
    <div
        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-yellow-100 dark:bg-red-800 dark:text-red-200">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
        </svg>
    </div>
    <div id="message" class="overflow-hidden truncate whitespace-nowrap text-sm font-semibold">
        {{ session('warning') }}
    </div>
    <button type="button" onclick="document.getElementById('toast-warning').classList.add('hidden');"
        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg bg-white text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white">
        <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-linecap="round"
            stroke-linejoin="round" viewBox="0 0 14 14">
            <path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>
<div id="loading"
    class="absolute end-4 top-4 z-50 hidden max-w-xs items-center gap-x-2 rounded-lg border border-blue-500 bg-white px-2 py-1.5 text-blue-600 shadow dark:bg-gray-800 dark:text-gray-400">
    <div
        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-blue-200 dark:bg-red-800 dark:text-red-200">
        <div class="size-4 inline-block animate-spin rounded-full border-[3px] border-current border-t-transparent dark:text-blue-500"
            role="status" aria-label="loading">
        </div>
    </div>
    <div id="message" class="overflow-hidden truncate whitespace-nowrap text-sm font-semibold">
        Tunggu sebentar
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const toastElements = document.querySelectorAll('[id*="toast"]');
    toastElements.forEach(function(toast) {
        if (toast.classList.contains('flex')) {
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 10000);
        }
    });
});

</script>