<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function createFromApi($data)
    {
        return static::create([
            'external_id' => $data['id'],
            'rarity_id' => Rarity::findOrCreate($data['rarity'])->id,
            'supertype_id' => Supertype::findOrCreate($data['rarity'])->id,
            'set_id' => Set::findByExternalId($data['set']['id'])->id,
            // 'name' => $data['name'],
            // 'national_pokedex_number' => join(',', $data['nationalPokedexNumber']),
            // 'hp' => $data['hp'],
            // 'number' => $data['number'],
            // 'artist' => $data['artist'],
        ]);
    }
}
