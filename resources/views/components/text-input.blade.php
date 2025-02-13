@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'font-medium text-sm placeholder-gray-500 dark:bg-gray-700 dark:text-white dark:border-white focus:ring-blue-800 dark:focus:border-blue-500 dark:focus:ring-blue-500 rounded-md shadow-sm',
]) !!}>
