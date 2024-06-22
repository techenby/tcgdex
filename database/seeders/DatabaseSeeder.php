<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            CardsSeeder::class,
        ]);
    }
}
