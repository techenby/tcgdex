<?php

namespace Database\Seeders;

use App\Http\Integrations\PokemonTcg\PokemonTcg;
use App\Http\Integrations\PokemonTcg\Requests\GetSupertypesRequest;
use App\Models\Supertype;
use Illuminate\Database\Seeder;

class SupertypesSeeder extends Seeder
{
    public function run(): void
    {
        $tcg = new PokemonTcg;
        $tcg->send(new GetSupertypesRequest)
            ->collect('data')
            ->each(fn ($supertype) => Supertype::create(['name' => $supertype]));
    }
}
