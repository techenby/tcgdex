<?php

use App\Models\Card;
use App\Models\User;
use Livewire\Volt\Volt;

test('search page is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/search')
        ->assertOk()
        ->assertSeeVolt('pages.search');
});

test('cannot search without session', function () {
    $this->get('/search')->assertRedirect();
});

test('can search for pokemon', function () {
    Card::createFromApi(json_decode(file_get_contents(__DIR__ . '/../../cards.json'), true)[0]);

    Volt::test('pages.search')
        ->set('query', 'Aggron')
        ->call('search')
        ->assertSeeHtml('<div id="hgss4-1"');
});

test('can add new pokemon to personal dex', function () {
    $card = Card::createFromApi(json_decode(file_get_contents(__DIR__ . '/../../cards.json'), true)[0]);
    $user = User::factory()->create();

    Volt::actingAs($user)
        ->test('pages.search')
        ->set('query', 'Aggron')
        ->call('search')
        ->assertSeeHtml('<div id="hgss4-1"')
        ->call('addToDex', $card->id);

    $this->assertDatabaseHas('cards', [
        'external_id' => 'hgss4-1',
        'name' => 'Aggron',
    ]);

    expect($user->fresh()->cards->firstWhere('id', $card->id))->not->toBeNull();
});
