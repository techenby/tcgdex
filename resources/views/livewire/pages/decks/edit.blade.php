<?php

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{computed, layout, mount, state, title, usesPagination};

usesPagination();

title(fn () => $this->deck->name . ' Deck');
layout('layouts.app');

state(['deck', 'query' => '', 'style']);

mount(function ($id) {
    $this->deck = Deck::find($id);
});

$deckCards = computed(fn () => $this->deck->cards->unique());

$collection = computed(fn () => $this->deck->collection());
$searchedCards = computed(fn () => Card::search($this->query)->paginate(10));

$add = fn ($cardId) => $this->deck->cards()->attach($cardId);

$sub = fn ($pivotId) => DB::table('card_deck')->whereId($pivotId)->delete();

$setStyle = function ($style) {
    session()->put('decks.edit.style', $style);
    $this->style = $style;
};

?>

<div>
    <div class="bg-white dark:bg-gray-800 py-2 border-t border-gray-300 dark:border-gray-700 shadow mb-8">
        <x-ui.container without-y-padding>
            <dl class="grid grid-cols-4 divide-x divide-gray-300 dark:divide-gray-700">
                <div class="pr-4">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Pokémon</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $this->deck->cards()->where('supertype', 'Pokémon')->count() }}</dd>
                </div>
                <div class="px-4">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Trainer</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $this->deck->cards()->where('supertype', 'Trainer')->count() }}</dd>
                </div>
                <div class="px-4">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Energy</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $this->deck->cards()->where('supertype', 'Energy')->count() }}</dd>
                </div>
                <div class="pl-4">
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Total</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $this->deck->cards()->count() }}</dd>
                </div>
            </dl>
        </x-ui.container>
    </div>

    <x-ui.container class="space-y-12" without-y-padding>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($this->deckCards as $deckCard)
            <x-card :wire:key="$deckCard->id" :card=$deckCard :collection="$this->collection" />
            @endforeach
        </div>

        <div @class([
            'bg-white dark:bg-gray-800 dark:border dark:border-gray-700 p-8 rounded-t-2xl shadow space-y-8 relative',
        ])>
            <span class="absolute -top-4 shadow bg-white px-3 py-2 dark:text-gray-100 dark:bg-gray-800 text-sm dark:border dark:border-gray-700 rounded-full">Add Cards to Deck</span>
            <form wire:submit="search" class="relative max-w-md mx-auto rounded-full ">
                <x-form.search />
            </form>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @if ($query !== '')
                @foreach ($this->searchedCards as $searchedCard)
                <x-card :wire:key="$searchedCard->id" :card=$searchedCard :collection="$this->collection" />
                @endforeach
                @else
                <x-fake-card />
                <x-fake-card class="[animation-delay:_0.5s]" />
                <x-fake-card class="[animation-delay:_1s]"/>
                <x-fake-card class="[animation-delay:_1.5s]"/>
                <x-fake-card class="[animation-delay:_2s] hidden lg:block" />
                @endif
            </div>
            @if ($query !== '')
            {{ $this->searchedCards->links() }}
            @endif
        </div>
    </x-ui.container>
</div>
