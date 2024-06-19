<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function createFromApi($data)
    {
        return static::create([
            'external_id' => $data['id'],
            'rarity_id' => Rarity::findOrCreate($data['rarity'])->id,
            'supertype_id' => Supertype::findOrCreate($data['supertype'])->id,
            'set_id' => Set::findByExternalId($data['set']['id'])->id,
            'name' => $data['name'],
            'hp' => $data['hp'],
            'types' => implode(',', $data['types']),
            'subtypes' => implode(',', $data['subtypes']),
            'converted_retreat_cost' => $data['convertedRetreatCost'],
            'number' => $data['number'],
            'artist' => $data['artist'],
            'flavor_text' => $data['flavorText'],
            'attacks' => $data['attacks'],
            'evolves_from' => $data['evolvesFrom'],
            'images' => $data['images'],
            'legalities' => $data['legalities'],
            'national_pokedex_numbers' => implode(',', $data['nationalPokedexNumbers']),
            'retreat_cost' => $data['retreatCost'],
            'rules' => data_get($data, 'rules'),
            'weaknesses' => collect(data_get($data, 'weaknesses'))->mapWithKeys(fn ($item) => [$item['type'] => $item['value']])->toArray(),
            'resistances' => collect(data_get($data, 'resistances'))->mapWithKeys(fn ($item) => [$item['type'] => $item['value']])->toArray(),
        ]);
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
            'attacks' => 'array',
            'images' => 'array',
            'legalities' => 'array',
            'retreat_cost' => 'array',
            'weaknesses' => 'array',
            'resistances' => 'array',
        ];
    }
}
