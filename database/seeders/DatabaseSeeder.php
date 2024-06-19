<?php

namespace Database\Seeders;

use App\Models\Rarity;
use App\Models\Set;
use App\Models\Subtype;
use App\Models\Supertype;
use App\Models\Type;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Import Types
        Http::withHeaders(['X-Api-Key' => config('services.pokemon_tcg.key')])
            ->get('https://api.pokemontcg.io/v2/types')
            ->collect('data')
            ->each(fn ($type) => Type::create(['name' => $type]));

        // Import Subtypes
        Http::withHeaders(['X-Api-Key' => config('services.pokemon_tcg.key')])
            ->get('https://api.pokemontcg.io/v2/subtypes')
            ->collect('data')
            ->each(fn ($type) => Subtype::create(['name' => $type]));

        // Import Supertypes
        Http::withHeaders(['X-Api-Key' => config('services.pokemon_tcg.key')])
            ->get('https://api.pokemontcg.io/v2/supertypes')
            ->collect('data')
            ->each(fn ($type) => Supertype::create(['name' => $type]));

        // Import Rarities
        Http::withHeaders(['X-Api-Key' => config('services.pokemon_tcg.key')])
            ->get('https://api.pokemontcg.io/v2/rarities')
            ->collect('data')
            ->each(fn ($type) => Rarity::create(['name' => $type]));

        // Import Sets
        Http::withHeaders(['X-Api-Key' => config('services.pokemon_tcg.key')])
            ->get('https://api.pokemontcg.io/v2/sets')
            ->collect('data')
            ->each(
                fn ($set) => Set::create([
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
                ])
            );
    }
}
