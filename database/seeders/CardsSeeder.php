<?php

namespace Database\Seeders;

use App\Http\Integrations\PokemonTcg\PokemonTcg;
use App\Http\Integrations\PokemonTcg\Requests\GetCardsRequest;
use App\Models\Card;
use Illuminate\Database\Seeder;

class CardsSeeder extends Seeder
{
    public function run(): void
    {
        $tcg = new PokemonTcg;

        $cards = $tcg->paginate(new GetCardsRequest);

        foreach ($cards->items() as $card) {
            if (! Card::where('external_id', $card['id'])->exists()) {
                Card::createFromApi($card);
            }
        }
    }
}
