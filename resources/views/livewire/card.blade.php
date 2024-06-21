<?php

use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{state};

state('card');

$add = fn ($cardId) => auth()->user()->cards()->attach($cardId);

$sub = fn ($pivotId) => DB::table('card_user')->whereId($pivotId)->delete();

?>

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
    <div class="absolute rounded-xl top-0 left-0 w-full h-full flex flex-col justify-center items-center backdrop-blur-sm bg-sky-300/50 border-8 border-sky-700 opacity-0 group-hover:opacity-100 duration-500">
        <button wire:click="add('{{ $card['id'] }}')" wire:loading.attr="disabled">Add</button>
        <button wire:click="sub('{{ $card['id'] }}')" wire:loading.attr="disabled">Subtract</button>
    </div>
</div>
