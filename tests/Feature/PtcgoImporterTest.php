<?php

use App\Models\Card;
use App\Models\Deck;
use App\Models\Set;
use App\PtcgoImporter;

test('can import deck', function () {
    buildWorld(Card::class, Set::class);

    $import = "Pokémon: 10
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
    $deck = Deck::factory()->create(['name' => 'Arcanine ex']);
    $deck->cards()->attach(PtcgoImporter::getCards($import));

    $cards = $deck->fresh()->cards->groupBy('supertype');

    expect($cards['Pokémon'])->toHaveCount(18)
        ->and($cards['Pokémon']->unique())->toHaveCount(10);
    expect($cards['Trainer'])->toHaveCount(31)
        ->and($cards['Trainer']->unique())->toHaveCount(13);
    expect($cards['Energy'])->toHaveCount(11)
        ->and($cards['Energy']->unique())->toHaveCount(1);
});
