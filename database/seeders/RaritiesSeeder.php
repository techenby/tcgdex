<?php

namespace Database\Seeders;

use App\Http\Integrations\PokemonTcg\PokemonTcg;
use App\Http\Integrations\PokemonTcg\Requests\GetRaritiesRequest;
use App\Models\Rarity;
use Illuminate\Database\Seeder;

class RaritiesSeeder extends Seeder
{
    public function run(): void
    {
        $tcg = new PokemonTcg;
        $tcg->send(new GetRaritiesRequest)
            ->collect('data')
            ->each(fn ($rarity) => Rarity::create(['name' => $rarity]));
    }
}
