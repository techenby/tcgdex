<?php

namespace Database\Seeders;

use App\Http\Integrations\PokemonTcg\PokemonTcg;
use App\Http\Integrations\PokemonTcg\Requests\GetRaritiesRequest;
use App\Http\Integrations\PokemonTcg\Requests\GetSetsRequest;
use App\Models\Rarity;
use App\Models\Set;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SetsSeeder extends Seeder
{
    public function run(): void
    {
        $tcg = new PokemonTcg;
        $tcg->send(new GetSetsRequest)
            ->collect('data')
            ->each(fn ($set) => Set::create([
                'external_id' => $set['id'],
                'name' => $set['name'],
                'series' => $set['series'],
                'printed_total' => $set['printedTotal'],
                'total' => $set['total'],
                'legalities' => $set['legalities'],
                'ptcgo_code' => $set['ptcgoCode'] ?? null,
                'release_date' => Carbon::parse($set['releaseDate']),
                'images' => $set['images'],
                'updated_at' => Carbon::parse($set['updatedAt']),
            ]));
    }
}
