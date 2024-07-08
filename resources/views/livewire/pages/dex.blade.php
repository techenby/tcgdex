<?php

use App\Models\Card;
use App\Models\Subtype;
use App\Models\Supertype;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{computed, layout, mount, on, state, title, usesPagination};

usesPagination();

title('Card Collection');
layout('layouts.app');

state([
    'style',
    'query' => '',
    'lists' => [],
    'filters' => [
        'supertypes' => [],
        'types' => [],
        'subtypes' => [],
    ],
    'order' => 'supertype',
]);

mount(function () {
    $this->style = session('dex.style', 'table');
    $this->lists = [
        'supertypes' => Supertype::all(),
        'types' => Type::all(),
        'subtypes' => Subtype::all(),
    ];
});

on(['added' => function () {
    unset($this->collection);
    unset($this->cards);
}, 'subtracted' => function () {
    unset($this->collection);
    unset($this->cards);
}]);

$collection = computed(fn () => auth()->user()->collection());
$cards = computed(fn () => auth()->user()->cards()
    ->when($this->filters['supertypes'] !== [], fn ($query) => $query->whereIn('supertype', $this->filters['supertypes']))
    ->when($this->filters['types'] !== [], fn ($query) => $query->whereJsonContains('types', $this->filters['types']))
    ->when($this->filters['subtypes'] !== [], fn ($query) => $query->whereJsonContains('subtypes', $this->filters['subtypes']))
    ->orderBy($this->order)->get()
    ->unique()->load('set'));

$setStyle = function ($style) {
    session()->put('dex.style', $style);
    $this->style = $style;
};

$add = function ($cardId) {
    auth()->user()->cards()->attach($cardId);
    $this->dispatch('added');
};
$sub = function ($pivotId) {
    DB::table('card_user')->whereId($pivotId)->delete();
    $this->dispatch('subtracted');
};

?>

<div>
    <x-ui.container class="space-y-8 mb-24">
        <div class="flex items-center justify-between space-x-4">
            <x-form.search class="w-full sm:w-3/5 md:w-1/3" />
            <div class="flex items-center space-x-4">
                <x-form.select wire:model.live="order" id="orderBy">
                    <option value="supertype">Supertype</option>
                    <option value="hp">HP</option>
                    <option value="name">Name</option>
                </x-form.select>
                <x-btn.group>
                    <x-btn.secondary wire:click="setStyle('grid')" size="lg" class="rounded-r-none focus:z-10">
                        <x-heroicon-o-squares-2x2 class="-ml-0.5 h-5 w-5 text-gray-400" />
                    </x-btn.secondary>
                    <x-btn.secondary wire:click="setStyle('table')" size="lg" class="rounded-l-none -ml-px focus:z-10">
                        <x-heroicon-o-table-cells class="-ml-0.5 h-5 w-5 text-gray-400" />
                    </x-btn.secondary>
                </x-btn.group>
            </div>
        </div>

        <section aria-labelledby="list-heading">
            <h2 id="list-heading" class="sr-only">Cards</h2>
            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-5">
                @include('partials.filters')

                <div class="lg:col-span-4">
                    @if ($style === 'grid')
                    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-6 w-full">
                        @foreach ($this->cards as $card)
                        <x-card :card=$card :collection="$this->collection" wire:key="{{ $card->id }}" />
                        @endforeach
                    </div>
                    @else
                    <x-table>
                        <x-slot:thead>
                            <tr>
                                <x-table.th>Name</x-table.th>
                                <x-table.th>Count</x-table.th>
                                <x-table.th>Supertype</x-table.th>
                                <x-table.th>Subtype</x-table.th>
                                <x-table.th>Type</x-table.th>
                                <x-table.th>HP</x-table.th>
                                <x-table.th>Abilities</x-table.th>
                                <x-table.th>Attacks</x-table.th>
                                <x-table.th>
                                    <span class="sr-only">Edit</span>
                                </x-table.th>
                            </tr>
                        </x-slot:thead>
                        <x-slot:tbody>
                            @forelse ($this->cards as $card)
                            <tr>
                                <x-table.td>{{ $card->name }}</x-table.td>
                                <x-table.td>{{ $card->count }}</x-table.td>
                                <x-table.td>{{ $card->supertype }}</x-table.td>
                                <x-table.td>{{ $card->subtypes?->implode(', ') }}</x-table.td>
                                <x-table.td>{{ $card->types?->implode(', ') }}</x-table.td>
                                <x-table.td>{{ $card->hp ?? '-' }}</x-table.td>
                                <x-table.td>{{ $card->abilities ?? '-' }}</x-table.td>
                                <x-table.td>{{ $card->attacks?->implode('name', ', ') }}</x-table.td>
                                <x-table.td>
                                    <button type="button" wire:click="increase({{ $card->id }})">
                                        Increase
                                    </button>
                                    <button type="button" wire:click="reduce({{ $card->pivot->id }})">
                                        Reduce
                                    </button>
                                </x-table.td>
                            </tr>
                            @empty
                            <tr>
                                <x-table.td colspan="8" class="text-center">No cards</x-table.td>
                                <x-table.td></x-table.td>
                            </tr>
                            @endforelse
                        </x-slot:tbody>
                    </x-table>
                    @endif
                </div>
            </div>
        </section>
    </x-ui.container>

    <livewire:search-cards :model="auth()->user()" />
</div>
