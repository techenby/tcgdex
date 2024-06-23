<?php

use App\Models\Card;

use function Livewire\Volt\{layout, state, computed, usesPagination};

usesPagination();

layout('layouts.app');

state([
    'query' => '',
]);

$cards = computed(fn () => Card::search($this->query)->paginate(10));

$addToDex = function ($id) {
    auth()->user()->cards()->attach($id);
};

?>

<div>
    <div class="py-12 px-8 space-y-8">
        <form wire:submit="search" class="relative max-w-md mx-auto rounded-full ">
            <x-form.search />
        </form>


        @if ($query !== '')
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($this->cards as $card)
            <div id="{{ $card->external_id }}" class="group relative">
                <img src="{{ $card->images['small'] }}" alt="{{ $card->name }} - {{ $card->flavor_text ?? '' }}" class="shadow rounded-xl">
                <div class="sr-only">
                    <dl>
                        <dt>Name</dt>
                        <dd>{{ $card->name }}</dd>
                        <dt>HP</dt>
                        <dd>{{ $card->hp }}</dd>
                    </dl>
                </div>
                <div class="absolute rounded-xl top-0 left-0 w-full h-full flex flex-col justify-center items-center bg-sky-700 opacity-0 group-hover:opacity-100 duration-500">
                    <button wire:click="addToDex('{{ $card['id'] }}')" wire:loading.attr="disabled">Add<span wire:loading>ing</span></button>
                </div>
            </div>
            @endforeach
        </div>
        {{ $this->cards->links() }}
        @endif
    </div>
</div>
