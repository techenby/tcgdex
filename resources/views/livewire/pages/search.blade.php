<?php

use App\Http\Integrations\PokemonTcg\PokemonTcg;
use App\Http\Integrations\PokemonTcg\Requests\GetCardsRequest;
use App\Models\Card;

use function Livewire\Volt\{layout, state};

layout('layouts.app');

state([
    'query' => '',
    'results' => [],
]);

$search = function () {
    $this->results = Card::where('name', $this->query)->get();
};

$addToDex = function ($id) {
    auth()->user()->cards()->attach($id);
};

?>

<div class="py-12 px-4 space-y-8">
    <form wire:submit="search" class="max-w-md mx-auto bg-white p-4 rounded-md shadow">
        <x-form.group name="query" wire:model="query" type="text" required placeholder="name:lapras hp:110"/>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach ($results as $card)
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
            <div class="absolute rounded-xl top-0 left-0 w-full h-full flex flex-col justify-center items-center bg-blue-700 opacity-0 group-hover:opacity-100 duration-500">
                <button wire:click="addToDex('{{ $card['id'] }}')" wire:loading.attr="disabled">Add<span wire:loading>ing</span></button>
            </div>
        </div>
        @endforeach
    </div>
</div>
