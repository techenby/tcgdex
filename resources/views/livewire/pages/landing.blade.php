<?php

use App\Models\Card;
use Illuminate\Contracts\Database\Eloquent\Builder;

use function Livewire\Volt\{computed, layout, mount, state, title, usesPagination};

usesPagination();

title('Collect Pokémon Cards');
layout('layouts.landing');

state([
    'query' => '',
    'randomCards' => [],
]);

mount(fn () => $this->randomCards = Card::inRandomOrder()->take(5)->get());

$cards = computed(fn () => Card::search($this->query)->paginate(10));

?>

<div>
    <div class="relative isolate">
        <x-landing.bg-grid />
        <x-landing.bg-gradient />
        <div class="overflow-hidden">
            <div class="mx-auto max-w-7xl px-6 pb-32 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
                <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
                    <div class="relative w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-6xl">Search for Pokémon Cards</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300 sm:max-w-md lg:max-w-none">
                            @auth
                            Add TCG Cards to your Dex by searching by name, HP and more.
                            @else
                            Create an account to create your own TCG Card Dex.
                            @endauth
                        </p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <form id="search" wire:submit="search" class="relative sm:max-w-md lg:max-w-lg w-full rounded-full">
                                <x-form.search />
                            </form>
                        </div>
                    </div>
                    <div class="mt-14 flex justify-end gap-8 sm:-mt-44 sm:justify-start sm:pl-20 lg:mt-0 lg:pl-0">
                        <div class="ml-auto w-44 flex-none space-y-8 pt-32 sm:ml-0 sm:pt-80 lg:order-last lg:pt-36 xl:order-none xl:pt-80">
                            <x-landing.card :card="$this->randomCards[0]" />
                        </div>
                        <div class="mr-auto w-44 flex-none space-y-8 sm:mr-0 sm:pt-52 lg:pt-36">
                            <x-landing.card :card="$this->randomCards[1]" />
                            <x-landing.card :card="$this->randomCards[2]" />
                        </div>
                        <div class="w-44 flex-none space-y-8 pt-32 sm:pt-0">
                            <x-landing.card :card="$this->randomCards[3]" />
                            <x-landing.card :card="$this->randomCards[4]" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-ui.container class="space-y-8 -mt-16" id="searched-cards">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @if ($query !== '')
            @foreach ($this->cards as $card)
            <x-card :wire:key="$card->id" :card=$card class="min-h-56 lg:min-h-64" />
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
        {{ $this->cards->links(data: ['scrollTo' => '#searched-cards']) }}
        @endif
    </x-ui.container>

    <div class="bg-white dark:bg-gray-900 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-sky-600 dark:text-sky-400">TCG DEX Features</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Everything needed to keep track of your Pokémon cards</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                            <x-heroicon-s-magnifying-glass-circle class="size-8 flex-none text-sky-600 dark:text-sky-400" />
                            Search the Card Database
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                            <p class="flex-auto">Our database includes all data from the <a href="https://docs.pokemontcg.io/" class="text-sky-600 dark:text-sky-400 hover:underline">Pokémon TCG API</a>. Any inconsistencies we find, we backport to the open source repository so everyone benifits.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                            <x-heroicon-s-folder-plus class="size-8 flex-none text-sky-600 dark:text-sky-400" />
                            Add Cards to Your Collection
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                            <p class="flex-auto">You can search for cards and add them to your collection. Have 50 Electric energies? We can help you keep track of them all.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900 dark:text-white">
                            <x-heroicon-s-beaker class="size-8 flex-none text-sky-600 dark:text-sky-400" />
                            Create and Import Decks
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                            <p class="flex-auto">If you have a favorite deck on Pokémon TCG Live, you can import it into your deck library, and see if you have the required cards to play it in real life.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

</div>
