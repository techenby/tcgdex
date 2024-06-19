<?php

use App\Http\Integrations\PokemonTcg\Requests\GetRaritiesRequest;
use App\Http\Integrations\PokemonTcg\Requests\GetSetsRequest;
use App\Http\Integrations\PokemonTcg\Requests\GetSubtypesRequest;
use App\Http\Integrations\PokemonTcg\Requests\GetSupertypesRequest;
use App\Http\Integrations\PokemonTcg\Requests\GetTypesRequest;
use Database\Seeders\RaritiesSeeder;
use Database\Seeders\SetsSeeder;
use Database\Seeders\SubtypesSeeder;
use Database\Seeders\SupertypesSeeder;
use Database\Seeders\TypesSeeder;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('can seed types in the database from pokemon tcg', function () {
    MockClient::global([
        GetTypesRequest::class => MockResponse::make(
            body: [
                'data' => [
                    'Colorless',
                    'Darkness',
                ],
            ],
            status: 200,
        ),
    ]);

    $this->assertDatabaseCount('types', 0);

    $this->seed(TypesSeeder::class);

    $this->assertDatabaseCount('types', 2);
    $this->assertDatabaseHas('types', [
        'name' => 'Colorless',
    ]);
    $this->assertDatabaseHas('types', [
        'name' => 'Darkness',
    ]);
});

test('can seed subtypes in the database from pokemon tcg', function () {
    MockClient::global([
        GetSubtypesRequest::class => MockResponse::make(
            body: [
                'data' => [
                    'Basic',
                    'EX',
                ],
            ],
            status: 200,
        ),
    ]);

    $this->assertDatabaseCount('subtypes', 0);

    $this->seed(SubtypesSeeder::class);

    $this->assertDatabaseCount('subtypes', 2);
    $this->assertDatabaseHas('subtypes', [
        'name' => 'Basic',
    ]);
    $this->assertDatabaseHas('subtypes', [
        'name' => 'EX',
    ]);
});

test('can seed supertypes in the database from pokemon tcg', function () {
    MockClient::global([
        GetSupertypesRequest::class => MockResponse::make(
            body: [
                'data' => [
                    'Energy',
                    'Pokémon',
                ],
            ],
            status: 200,
        ),
    ]);

    $this->assertDatabaseCount('supertypes', 0);

    $this->seed(SupertypesSeeder::class);

    $this->assertDatabaseCount('supertypes', 2);
    $this->assertDatabaseHas('supertypes', [
        'name' => 'Energy',
    ]);
    $this->assertDatabaseHas('supertypes', [
        'name' => 'Pokémon',
    ]);
});

test('can seed rarities in the database from pokemon tcg', function () {
    MockClient::global([
        GetRaritiesRequest::class => MockResponse::make(
            body: [
                'data' => [
                    'Common',
                    'Rare',
                ],
            ],
            status: 200,
        ),
    ]);

    $this->assertDatabaseCount('rarities', 0);

    $this->seed(RaritiesSeeder::class);

    $this->assertDatabaseCount('rarities', 2);
    $this->assertDatabaseHas('rarities', [
        'name' => 'Common',
    ]);
    $this->assertDatabaseHas('rarities', [
        'name' => 'Rare',
    ]);
});

test('can seed sets in the database from pokemon tcg', function () {
    MockClient::global([
        GetSetsRequest::class => MockResponse::make(
            body: [
                'data' => [
                    [
                            "id" => "swsh1",
                            "name" => "Sword & Shield",
                            "series" => "Sword & Shield",
                            "printedTotal" => 202,
                            "total" => 216,
                            "legalities" => [
                                "unlimited" => "Legal",
                                "standard" => "Legal",
                                "expanded" => "Legal"
                            ],
                            "ptcgoCode" => "SSH",
                            "releaseDate" => "2020/02/07",
                            "updatedAt" => "2020/08/14 09:35:00",
                            "images" => [
                                "symbol" => "https://images.pokemontcg.io/swsh1/symbol.png",
                                "logo" => "https://images.pokemontcg.io/swsh1/logo.png"
                            ]
                    ]
                ],
            ],
            status: 200,
        ),
    ]);

    $this->assertDatabaseCount('sets', 0);

    $this->seed(SetsSeeder::class);

    $this->assertDatabaseCount('sets', 1);
    $this->assertDatabaseHas('sets', [
        'external_id' => 'swsh1',
        'name' => 'Sword & Shield',
    ]);
});
