<?php

use App\Livewire\Forms\DeckForm;

use function Livewire\Volt\{computed, form, layout, title};

title('All Decks');
layout('layouts.app');

form(DeckForm::class);


$decks = computed(fn () => auth()->user()->decks()->with('cards')->get());

$create = function () {
    $this->form->store();

    $this->form->reset();
};

$delete = function ($id) {
    $deck = $this->decks->firstWhere('id', $id);

    if ($deck) {
        $deck->delete();
        unset($this->decks);
    }
};

?>

<div>
    <x-ui.container class="mb-16">
        <x-table>
            <x-slot:thead>
                <tr>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Pokémon</x-table.th>
                    <x-table.th>Trainer</x-table.th>
                    <x-table.th>Energy</x-table.th>
                    <x-table.th>Total</x-table.th>
                    <x-table.th>
                        <span class="sr-only">Edit</span>
                    </x-table.th>
                </tr>
            </x-slot:thead>
            <x-slot:tbody>
                @forelse ($this->decks as $deck)
                <tr>
                    <x-table.td>{{ $deck->name }}</x-table.td>
                    <x-table.td>{{ $deck->cards->where('supertype', 'Pokémon')->count() }}</x-table.td>
                    <x-table.td>{{ $deck->cards->where('supertype', 'Trainer')->count() }}</x-table.td>
                    <x-table.td>{{ $deck->cards->where('supertype', 'Energy')->count() }}</x-table.td>
                    <x-table.td>{{ $deck->cards->count() }}</x-table.td>
                    <x-table.td class="space-x-2">
                        <a href="{{ route('decks.edit', $deck) }}">Edit</a>
                        <button type="button" wire:click="delete({{ $deck->id }})">
                            Delete
                        </button>
                    </x-table.td>
                </tr>
                @empty
                <tr>
                    <x-table.td colspan="6">No decks</x-table.td>
                </tr>
                @endforelse
            </x-slot:tbody>
        </x-table>
    </x-ui.container>

    <div class="fixed bottom-0 w-full">
        <x-ui.container class="max-w-md" without-y-padding>
            <div x-data="{expanded: false}" @class(['min-h-8 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 px-8 rounded-t-2xl drop-shadow-3xl relative'])>
                <button @click="expanded = ! expanded" class="z-10 absolute -top-4 shadow bg-white px-3 py-2 dark:text-gray-100 dark:bg-gray-800 text-sm dark:border dark:border-gray-700 rounded-full">
                    Add New Deck
                </button>
                <div x-show="expanded" x-collapse class="space-y-8 max-h-[50vh] overflow-scroll pb-8 pt-8 -mx-8 px-8">
                    <form wire:submit="create" class="space-y-4">
                        <x-form.group name="name" wire:model="form.name" type="text" />
                        <x-form.group name="notes" wire:model="form.notes" type="textarea" />

                        <x-primary-button>Save</x-primary-button>
                    </form>
                </div>
            </div>
        </x-ui.container>
    </div>
</div>
