<?php

use App\Models\User;
use Livewire\Volt\Volt;

it('can render', function () {
    Volt::test('search-cards', ['model' => User::factory()->create()])
        ->assertSee('Add Card to Collection');
});
