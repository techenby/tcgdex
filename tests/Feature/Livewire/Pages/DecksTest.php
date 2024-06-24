<?php

use App\Models\Card;
use App\Models\Deck;
use App\Models\Set;
use App\Models\User;
use Livewire\Volt\Volt;

test('decks page is displayed', function () {
    $this->actingAs(User::factory()->create())
        ->get('/decks')
        ->assertOk()
        ->assertSeeVolt('pages.decks');
});

test('cannot see decks without session', function () {
    $this->get('/decks')->assertRedirect();
});

test('can see decks', function () {
    $user = User::factory()->create();
    Deck::factory()->for($user)->create(['name' => 'Vulpix Cook']);

    Volt::actingAs($user)
        ->test('pages.decks')
        ->assertSeeHtml('Vulpix Cook');
});

test('cannot see other peoples decks', function () {
    Deck::factory()->create(['name' => 'Vulpix Cook']);

    Volt::actingAs(User::factory()->create())
        ->test('pages.decks')
        ->assertDontSee('Vulpix Cook')
        ->assertSee('No decks');
});

test('can create deck', function () {
    buildWorld(Set::class, Card::class);

    $deck = "Pokémon: 10
1 Charizard ex MEW 6
3 Arcanine ex SVI 32
1 Moltres BRS 21
3 Growlithe SVI 31
2 Charmander PGO 8
2 Bidoof CRZ 111
1 Charmeleon PGO 9
2 Charizard PGO 10
1 Radiant Charizard PGO 11
2 Bibarel BRS 121

Trainer: 13
4 Ultra Ball SVI 196
2 Switch SVI 194
2 Boss's Orders BRS 132
3 Professor's Research SVI 190
3 Magma Basin BRS 144
3 Rare Candy SVI 191
1 Defiance Band SVI 169
2 Super Rod PAL 188
2 Mela PAR 167
3 Nest Ball SVI 181
2 Exp. Share SVI 174
1 Energy Search SVI 172
3 Arven SVI 166

Energy: 1
11 Basic {R} Energy SVE 2

Total Cards: 60
";

    Volt::actingAs(User::factory()->create())
        ->test('pages.decks')
        ->set('form.name', 'Arcanine ex')
        ->set('form.notes', $deck)
        ->call('create')
        ->assertSeeInOrder([
            'Arcanine ex',
            18,
            31,
            11,
            60,
        ]);
});

test('can delete deck', function () {
    $user = User::factory()->create();
    $deck = Deck::factory()->for($user)->create(['name' => 'Arcanine ex']);

    Volt::actingAs($user)
        ->test('pages.decks')
        ->assertSee('Arcanine ex')
        ->call('delete', $deck->id)
        ->assertSee('No decks');

    expect($deck->fresh())->toBeNull();
});

test('cannot delete deck that is not yours', function () {
    $deck = Deck::factory()->create(['name' => 'Arcanine ex']);

    Volt::actingAs(User::factory()->create())
        ->test('pages.decks')
        ->call('delete', $deck->id);

    expect($deck->fresh())->not->toBeNull();
});
