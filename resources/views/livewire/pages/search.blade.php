<?php

use App\Models\Card;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{computed, layout, state, title, usesPagination};

usesPagination();

title('Search All Cards');
layout('layouts.app');

state([
    'query' => '',
]);

$collection = computed(fn () => auth()->user()->collection());
$cards = computed(fn () => Card::search($this->query)->paginate(10));

$add = fn ($cardId) => auth()->user()->cards()->attach($cardId);

$sub = fn ($pivotId) => DB::table('card_user')->whereId($pivotId)->delete();

?>

<x-ui.container class="space-y-8">
    <form wire:submit="search" class="relative max-w-md mx-auto rounded-full ">
        <x-form.search />
    </form>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @if ($query !== '')
        @foreach ($this->cards as $card)
        <x-card :wire:key="$card->id" :card=$card :collection="$this->collection" />
        @endforeach
        @else
        <x-fake-card />
        <x-fake-card class="[animation-delay:_0.5s]" />
        <x-fake-card class="[animation-delay:_1s]" />
        <x-fake-card class="[animation-delay:_1.5s]" />
        <x-fake-card class="[animation-delay:_2s] hidden lg:block" />
        @endif
    </div>
    @if ($query !== '')
    {{ $this->cards->links() }}
    @endif
</x-ui.container>
