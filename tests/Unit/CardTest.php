<?php

use App\Models\Card;
use App\Models\Set;

test('can create card from api data', function () {
    buildWorld(Set::class);

    $cardData = json_decode(file_get_contents(__DIR__ . '/../api-card.json'), true)[0];

    $card = Card::createFromApi($cardData);

    expect($card->external_id)->toBe('hgss4-1')
        ->and($card->rarity)->toBe('Rare Holo')
        ->and($card->supertype)->toBe('Pokémon')
        ->and($card->set_id)->toBe(61)
        ->and($card->name)->toBe('Aggron')
        ->and($card->hp)->toBe('140')
        ->and($card->types->first())->toBe('Metal')
        ->and($card->subtypes->first())->toBe('Stage 2')
        ->and($card->converted_retreat_cost)->toBe(4)
        ->and($card->number)->toBe('1')
        ->and($card->artist)->toBe('Kagemaru Himeno')
        ->and($card->flavor_text)->toBe('You can tell its age by the length of its iron horns. It claims an entire mountain as its territory.')
        ->and($card->attacks)->toHaveCount(2)
        ->and($card->evolves_from)->toBe('Lairon')
        ->and($card->evolves_to)->toBeNull()
        ->and($card->images)->toHaveCount(2)
        ->and($card->legalities)->toHaveCount(1)
        ->and($card->national_pokedex_numbers)->toBe([306])
        ->and($card->retreat_cost)->toHaveCount(4)
        ->and($card->rules)->toBeNull()
        ->and($card->weaknesses)->toBe([['type' => 'Fire', 'value' => '×2']])
        ->and($card->resistances)->toBe([['type' => 'Psychic', 'value' => '-20']]);
});
