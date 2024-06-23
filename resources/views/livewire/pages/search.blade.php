<?php

use App\Models\Card;

use function Livewire\Volt\{layout, state, computed, usesPagination};

usesPagination();

layout('layouts.app');

state([
    'query' => '',
]);

$cards = computed(fn () => Card::search($this->query)->paginate(10));

$add = fn ($cardId) => auth()->user()->cards()->attach($cardId);

$sub = fn ($pivotId) => DB::table('card_user')->whereId($pivotId)->delete();

?>

<div>
    <div class="py-12 px-8 space-y-8">
        <form wire:submit="search" class="relative max-w-md mx-auto rounded-full ">
            <x-form.search />
        </form>


        @if ($query !== '')
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($this->cards as $card)
            <x-card :wire:key="$card->id" :card=$card />
            @endforeach
        </div>
        {{ $this->cards->links() }}
        @endif
    </div>
</div>
