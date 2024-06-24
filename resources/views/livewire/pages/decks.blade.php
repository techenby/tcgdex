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
    $this->decks->firstWhere('id', $id)->delete();
    $this->emit('$refresh');
};

?>

<x-ui.container class="space-y-8">
    <form wire:submit="create" class="space-y-4 bg-white dark:bg-gray-800 p-4 rounded-md shadow max-w-md">
        <h2 class="text-lg text-gray-900 dark:text-gray-100">Add Deck</h2>
        <x-form.group name="name" wire:model="form.name" type="text" />
        <x-form.group name="notes" wire:model="form.notes" type="textarea" />

        <x-primary-button>Save</x-primary-button>
    </form>

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
            @foreach ($this->decks as $deck)
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
            @endforeach
        </x-slot:tbody>
    </x-table>
</x-ui.container>
