@php
    $label = ucfirst($label ?? $attributes->get('name'));
    $id = $id ?? $attributes->get('name');
    $error = $errors->get($attributes->get('wire:model'));
@endphp

<div>
    <x-form.label :for="$id" :value="__($label)" />
    @if ($attributes->get('type') === 'textarea')
    <x-dynamic-component :component="'form.' . $attributes->get('type')" {{ $attributes->twMerge(['class' => 'block mt-1 w-full']) }} />
    @else
    <x-form.input {{ $attributes->merge(['class' => 'block mt-1 w-full' , 'type' => 'text']) }} />
    @endif
    <x-form.error :messages="$error" class="mt-2" />
</div>
