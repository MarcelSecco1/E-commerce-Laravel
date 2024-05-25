@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-azul-200 dark:focus:border-azul-200 focus:ring-indigo-500 dark:focus:ring-azul-200 rounded-md shadow-sm',
]) !!}>
