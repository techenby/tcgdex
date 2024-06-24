<?php

use App\Models\Card;
use Livewire\Volt\Volt;

it('can render', function () {
    buildWorld(Card::class);

    Volt::test('pages.landing')
        ->assertOk();
});
