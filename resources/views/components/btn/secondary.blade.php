@props(['size' => false, 'icon'])

@php
    $size = match($size) {
        'xs' => 'rounded px-2 py-1 text-xs',
        'sm' => 'rounded px-2 py-1 text-sm',
        'lg' => 'rounded-md px-3 py-2 text-sm',
        'xl' => 'rounded-md px-3.5 py-2.5 text-sm',
        default => 'rounded-md px-2.5 py-1.5 text-sm',
    }
@endphp

<button {{ $attributes->merge(['type' => 'button'])->twMerge($size . ' bg-white dark:bg-white/10 font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-white/20') }}>
    {{ $slot }}
</button>
