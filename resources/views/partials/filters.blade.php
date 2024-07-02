@props(['lists'])

<form class="hidden lg:block">
    <h3 class="sr-only">Filters</h3>
    @foreach ($lists as $key => $list)
    <div x-data="{ open: false }" class="border-b border-gray-200 py-6">
        <h3 class="-my-3 flow-root">
            <button type="button" x-description="Expand/collapse section button" class="flex w-full items-center justify-between bg-gray-100 dark:bg-gray-900 py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-{{ $key }}" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                <span class="font-medium text-gray-900 dark:text-gray-100">{{ ucfirst($key) }}</span>
                <span class="ml-6 flex items-center">
                    <x-heroicon-o-plus class="size-5" x-description="Expand icon, show/hide based on section open state." x-show="!(open)" aria-hidden="true" />
                    <x-heroicon-o-minus class="size-5" x-description="Collapse icon, show/hide based on section open state." x-show="open" aria-hidden="true" x-cloak />
                </span>
            </button>
        </h3>
        <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-{{ $key }}" x-show="open" style="display: none;">
            <div class="space-y-4">
                @foreach ($list as $item)
                <div class="flex items-center">
                    <input id="filter-{{ $key }}-{{ $item->id }}" wire:model.live="filters.{{ $key }}" value="{{ $item->name }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                    <label for="filter-{{ $key }}-{{ $item->id }}" class="ml-3 text-sm text-gray-600">{{ $item->name }}</label>
                </div>
                @endforeach
            </div>
        </div>
    </div>
   @endforeach
</form>
