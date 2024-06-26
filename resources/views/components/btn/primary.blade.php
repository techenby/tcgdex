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

<button {{ $attributes->merge(['type' => 'button'])->twMerge($size . ' bg-sky-600 dark:bg-sky-500 font-semibold text-white shadow-sm hover:bg-sky-500 dark:hover:bg-sky-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 dark:focus-visible:outline-sky-500') }}>
    {{ $slot }}
</button>
