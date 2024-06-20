<?php

use App\Http\Integrations\PokemonTcg\PokemonTcg;
use App\Http\Integrations\PokemonTcg\Requests\GetCardsRequest;
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
    <div class="py-12 px-4 space-y-8">
        <form wire:submit="search" class="relative max-w-md mx-auto rounded-full ">
            <label for="query" class="sr-only">Search for Cards</label>
            <x-form.input wire:model.live="query" type="text" placeholder="Search by name, HP and more" class="w-full py-4 rounded-full md:text-lg md:py-4 md:px-6" />
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-7 stroke-gray-700 dark:stroke-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </div>
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
