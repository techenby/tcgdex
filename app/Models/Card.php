<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function makeFromApi($data)
    {
        return static::make([
            'external_id' => $data['id'],
            'rarity' => data_get($data, 'rarity'),
            'supertype' => data_get($data, 'supertype'),
            'set_id' => data_get($data, 'set.id'),
            'name' => data_get($data, 'name'),
            'hp' => data_get($data, 'hp'),
            'types' => data_get($data, 'types'),
            'subtypes' => data_get($data, 'subtypes'),
            'converted_retreat_cost' => data_get($data, 'convertedRetreatCost'),
            'number' => data_get($data, 'number'),
            'artist' => data_get($data, 'artist'),
            'flavor_text' => data_get($data, 'flavorText'),
            'attacks' => data_get($data, 'attacks'),
            'evolves_from' => data_get($data, 'evolvesFrom'),
            'images' => data_get($data, 'images'),
            'legalities' => data_get($data, 'legalities'),
            'national_pokedex_numbers' => data_get($data, 'nationalPokedexNumbers'),
            'retreat_cost' => data_get($data, 'retreatCost'),
            'rules' => data_get($data, 'rules'),
            'weaknesses' => data_get($data, 'weaknesses'),
            'resistances' => data_get($data, 'resistances'),
        ]);
    }

    public static function createFromApi($data)
    {
        $card = static::makeFromApi($data);
        $card->save();

        return $card;
    }

    public function rarity(): BelongsTo
    {
        return $this->belongsTo(Rarity::class);
    }

    public function set(): BelongsTo
    {
        return $this->belongsTo(Set::class);
    }

    public function supertype(): BelongsTo
    {
        return $this->belongsTo(Supertype::class);
    }

    protected function casts(): array
    {
        return [
            'subtypes' => 'array',
            'types' => 'array',
            'evolves_to' => 'array',
            'rules' => 'array',
            'retreat_cost' => 'array',
            'ancient_trait' => 'array',
            'abilities' => 'array',
            'attacks' => 'array',
            'weaknesses' => 'array',
            'resistances' => 'array',
            'national_pokedex_numbers' => 'array',
            'legalities' => 'array',
            'images' => 'array',
        ];
    }
}
