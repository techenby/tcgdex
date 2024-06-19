@php
    $label = ucfirst($label ?? $attributes->get('name'));
    $id = $id ?? $attributes->get('name');
    $error = $errors->get($attributes->get('wire:model'));
@endphp

<div>
    <x-form.label :for="$id" :value="__($label)" />
    <x-form.input {{ $attributes->merge(['class' => 'block mt-1 w-full' , 'type' => 'text']) }} />
    <x-form.error :messages="$error" class="mt-2" />
</div>
