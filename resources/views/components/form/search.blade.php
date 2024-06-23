<div {{ $attributes->twMerge('relative flex items-center') }}>
    <label for="query" class="sr-only">Search for Cards</label>
    <div class="absolute inset-y-0 left-0 flex py-2 pl-2 text-gray-400">
        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="h-6 w-6 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12.01 12a4.25 4.25 0 1 0-6.02-6 4.25 4.25 0 0 0 6.02 6Zm0 0 3.24 3.25"></path>
        </svg>
    </div>
    <input type="search" name="query" wire:model.live="query" id="query" placeholder="Find by name, hp or attack" class="block w-full rounded-full border-0 py-2 pr-4 pl-9 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:leading-6 dark:bg-white/5 dark:text-zinc-400 dark:ring-inset dark:ring-white/10 dark:hover:ring-white/20">
    <!-- <div class="absolute inset-y-0 right-0 flex py-2 pr-2">
        <kbd class="inline-flex items-center rounded-full border border-gray-200 px-2 font-sans text-xs text-gray-400">⌘K</kbd>
    </div> -->
</div>
