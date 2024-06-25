@props(['withoutYPadding' => false])

<div {{ $attributes->twMerge('mx-auto max-w-7xl px-4 sm:px-6 lg:px-8' . ($withoutYPadding ? '' : ' py-4 sm:py-6 lg:py-8')) }}>
    {{ $slot }}
</div>
