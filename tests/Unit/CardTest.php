<?php

use App\Models\Card;
use Database\Seeders\SetsSeeder;

test('can create card from api data', function () {
    $this->seed(SetsSeeder::class);

    $cardData = json_decode(file_get_contents(__DIR__ . '/../cards.json'), true)[0];

    $card = Card::createFromApi($cardData);

    expect($card->external_id)->toBe('hgss4-1')
        ->and($card->rarity->name)->toBe('Rare Holo')
        ->and($card->supertype->name)->toBe('Pokémon')
        ->and($card->set->external_id)->toBe('hgss4')
        ->and($card->name)->toBe('Aggron')
        ->and($card->hp)->toBe('140')
        ->and($card->types)->toBe('Metal')
        ->and($card->subtypes)->toBe('Stage 2')
        ->and($card->converted_retreat_cost)->toBe(4)
        ->and($card->number)->toBe('1')
        ->and($card->artist)->toBe('Kagemaru Himeno')
        ->and($card->flavor_text)->toBe('You can tell its age by the length of its iron horns. It claims an entire mountain as its territory.')
        ->and($card->attacks)->toHaveCount(2)
        ->and($card->evolves_from)->toBe('Lairon')
        ->and($card->evolves_to)->toBeNull()
        ->and($card->images)->toHaveCount(2)
        ->and($card->legalities)->toHaveCount(1)
        ->and($card->national_pokedex_numbers)->toBe('306')
        ->and($card->retreat_cost)->toHaveCount(4)
        ->and($card->rules)->toBeNull()
        ->and($card->weaknesses)->toBe(['Fire' => '×2'])
        ->and($card->resistances)->toBe(['Psychic' => '-20']);
});
