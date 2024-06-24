<?php

use App\Models\Card;
use App\Models\Set;
use App\Models\User;
use Livewire\Volt\Volt;

test('search page is displayed', function () {
    $this->actingAs(User::factory()->create())
        ->get('/search')
        ->assertOk()
        ->assertSeeVolt('pages.search');
});

test('cannot search without session', function () {
    $this->get('/search')->assertRedirect();
});

test('can search for pokemon', function () {
    buildWorld(Set::class, Card::class);

    Volt::actingAs(User::factory()->create())
        ->test('pages.search')
        ->set('query', 'Moltres')
        ->assertSeeHtml('<div id="swsh9-21"');
});

test('can add new pokemon to personal dex', function () {
    buildWorld(Set::class, Card::class);
    $user = User::factory()->create();

    $card = Card::firstWhere('external_id', 'swsh9-21');

    Volt::actingAs($user)
        ->test('pages.search')
        ->set('query', 'Moltres')
        ->assertSeeHtml('<div id="swsh9-21"')
        ->call('add', $card->id);

    $this->assertDatabaseHas('cards', [
        'external_id' => 'swsh9-21',
        'name' => 'Moltres',
    ]);

    expect($user->fresh()->cards->firstWhere('id', $card->id))->not->toBeNull();
});
