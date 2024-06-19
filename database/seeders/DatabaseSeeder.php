<?php

namespace Database\Seeders;

use App\Models\Rarity;
use App\Models\Set;
use App\Models\Subtype;
use App\Models\Supertype;
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

        $this->call([
            TypesSeeder::class,
            SubtypesSeeder::class,
            SupertypesSeeder::class,
            RaritiesSeeder::class,
            SetsSeeder::class,
        ]);
    }
}
