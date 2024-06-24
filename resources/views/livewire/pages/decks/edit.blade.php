<?php

use App\Models\Card;
use App\Models\Deck;

use function Livewire\Volt\{computed, layout, mount, state, title, usesPagination};

usesPagination();

title(fn () => $this->deck->name . ' Deck');
layout('layouts.app');

state(['deck', 'query' => '']);

mount(function ($id) {
    $this->deck = Deck::find($id);
});

$collection = computed(fn () => $this->deck->collection());
$cards = computed(fn () => Card::search($this->query)->paginate(10));

?>

<div>
    <div class="py-12 px-8 space-y-8">
        <form wire:submit="search" class="relative max-w-md mx-auto rounded-full ">
            <x-form.search />
        </form>

        @if ($query !== '')
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($this->cards as $card)
            <x-card :wire:key="$card->id" :card=$card :collection="$this->collection" />
            @endforeach
        </div>
        {{ $this->cards->links() }}
        @endif
    </div>
</div>
