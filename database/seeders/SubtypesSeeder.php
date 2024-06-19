<?php

namespace Database\Seeders;

use App\Http\Integrations\PokemonTcg\PokemonTcg;
use App\Http\Integrations\PokemonTcg\Requests\GetSubtypesRequest;
use App\Models\Subtype;
use Illuminate\Database\Seeder;

class SubtypesSeeder extends Seeder
{
    public function run(): void
    {
        $tcg = new PokemonTcg;
        $tcg->send(new GetSubtypesRequest)
            ->collect('data')
            ->each(fn ($subtype) => Subtype::create(['name' => $subtype]));
    }
}
