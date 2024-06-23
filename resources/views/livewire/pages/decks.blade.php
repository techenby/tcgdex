<?php

use App\Livewire\Forms\DeckForm;

use function Livewire\Volt\{computed, form, layout, state};

layout('layouts.app');

form(DeckForm::class);

$decks = computed(fn () => auth()->user()->decks()->withCount('cards')->get());

$create = function () {
    $this->form->store();
};

?>

<x-ui.container>
    <form wire:submit="create" class="space-y-4 bg-white dark:bg-gray-800 p-4 rounded-md max-w-md">
        <h2 class="text-lg text-gray-900 dark:text-gray-100">Add Deck</h2>
        <x-form.group name="name" wire:model="name" type="text" />
        <x-form.group name="notes" wire:model="notes" type="textarea" />

        <x-primary-button>Save</x-primary-button>
    </form>

    <x-table>
        <x-slot:thead>
            <tr>
                <x-table.th>Name</x-table.th>
                <x-table.th>Count</x-table.th>
                <x-table.th>
                    <span class="sr-only">Edit</span>
                </x-table.th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
            @foreach ($this->decks as $deck)
            <tr>
                <x-table.td>{{ $deck->name }}</x-table.td>
                <x-table.td>{{ $deck->cards_count }}</x-table.td>
                <x-table.td>
                    //
                </x-table.td>
            </tr>
            @endforeach
        </x-slot:tbody>
    </x-table>
</x-ui.container>
