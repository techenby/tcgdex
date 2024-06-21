@props(['size' => false, 'icon'])

@php
    $size = match($size) {
        'sm' => 'p-1',
        'lg' => 'p-2',
        default => 'p-1.5',
    }
@endphp

<button type="button" {{ $attributes->twMerge($size . ' rounded-full bg-sky-600 text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 ficus-visible:outline-offset-2 focus-visible:outline-sky-600') }}>
  <x-dynamic-component :component="$icon" class="size-5" />
  <span class="sr-only">{{ $slot }}</span>
</button>
