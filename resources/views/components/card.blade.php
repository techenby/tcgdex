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
    <div class="absolute rounded-xl top-0 left-0 w-full h-full flex flex-col justify-center items-center backdrop-blur-sm bg-sky-700/70 border-8 border-sky-700 opacity-0 group-hover:opacity-100 duration-500">
        <p class="text-center text-white">{{ $card->set->name }}</p>
        <p class="text-center text-white">{{ Str::padLeft($card->number, 3, 0) }}/{{ Str::padLeft($card->set->printed_total, 3, 0) }}</p>
    </div>
    <div class="absolute inset-x-0 flex items-center justify-between px-4 -bottom-2 h-8">
        <x-btn.icon-pill wire:click="add('{{ $card->id }}')" wire:loading.attr="disabled" icon="heroicon-o-plus-small" class="opacity-0 group-hover:opacity-100">Add</x-btn.icon-pill>
        @isset($card->pivot)
        <div class="size-8 flex items-center justify-center shadow bg-white dark:text-gray-100 dark:bg-gray-800 border-2 rounded-full">{{ $card['count'] }}</div>
        <x-btn.icon-pill wire:click="sub('{{ $card->pivot->id }}')" wire:loading.attr="disabled" icon="heroicon-o-minus-small" class="opacity-0 group-hover:opacity-100">Remove</x-btn.icon-pill>
        @endisset
        @if (isset($collection) && $collection->firstWhere('card_id', $card->id) !== null)
        <div class="size-8 flex items-center justify-center shadow bg-white dark:text-gray-100 dark:bg-gray-800 border-2 rounded-full">{{ $collection->firstWhere('card_id', $card->id)->count }}</div>
        <x-btn.icon-pill wire:click="sub('{{ $collection->firstWhere('card_id', $card->id)->last_id }}')" wire:loading.attr="disabled" icon="heroicon-o-minus-small" class="opacity-0 group-hover:opacity-100">Remove</x-btn.icon-pill>
        @endif
    </div>
</div>
