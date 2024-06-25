<?php

use App\Models\Card;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{computed, mount, state, usesPagination};

usesPagination();

state(['label', 'model', 'query' => '']);

mount(function () {
    $this->label = match (get_class($this->model)) {
        User::class => 'Add Card to Collection',
        Deck::class => 'Add Card to Deck',
    };
});

$collection = computed(fn () => $this->model->collection());
$searchedCards = computed(fn () => Card::search($this->query)->paginate(10));

$add = fn ($cardId) => $this->model->cards()->attach($cardId);
$sub = function ($pivotId) {
    $table = match (get_class($this->model)) {
        User::class => 'card_user',
        Deck::class => 'card_deck',
    };
    DB::table($table)->whereId($pivotId)->delete();
};

?>

<div class="fixed bottom-0 w-full">
    <x-ui.container without-y-padding>
        <div x-data="{expanded: false}" @class(['min-h-8 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 px-8 rounded-t-2xl shadow relative'])>
            <button @click="expanded = ! expanded" class="z-10 absolute -top-4 shadow bg-white px-3 py-2 dark:text-gray-100 dark:bg-gray-800 text-sm dark:border dark:border-gray-700 rounded-full">
                {{ $label }}
            </button>
            <div x-show="expanded" x-collapse class="space-y-8 max-h-[50vh] overflow-scroll pb-8 pt-8 -mx-8 px-8">
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
                    <x-fake-card class="[animation-delay:_1s]" />
                    <x-fake-card class="[animation-delay:_1.5s]" />
                    <x-fake-card class="[animation-delay:_2s] hidden lg:block" />
                    @endif
                </div>
                @if ($query !== '')
                {{ $this->searchedCards->links() }}
                @endif
            </div>
        </div>
    </x-ui.container>
</div>
