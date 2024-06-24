<?php

use App\Models\User;
use Livewire\Volt\Volt;

it('can render', function () {
    $component = Volt::actingAs(User::factory()->create())->test('pages.dex');

    $component->assertSee('');
});
