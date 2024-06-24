<?php

use App\Models\User;
use Livewire\Volt\Volt;

it('can render', function () {
    Volt::actingAs(User::factory()->create())
        ->test('pages.dex')
        ->assertSee('');
});
