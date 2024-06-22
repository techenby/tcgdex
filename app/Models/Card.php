<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Card extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    public static function createFromApi($data)
    {
        return static::create([
            'external_id' => $data['id'],
            'rarity' => data_get($data, 'rarity'),
            'supertype' => data_get($data, 'supertype'),
            'set_id' => value(function ($id) {
                return Set::select('id')->firstWhere('external_id', $id)->id;
            }, data_get($data, 'set.id')),
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

    public function toSearchableArray()
    {
        return array_merge($this->toArray(), [
            'id' => (string) $this->id,
            'name' => $this->name,
            'hp' => (string) $this->hp,
            'attacks' => $this->attacks?->implode('name', ', ') ?? '',
        ]);
    }

    protected function casts(): array
    {
        return [
            'subtypes' => AsCollection::class,
            'types' => AsCollection::class,
            'evolves_to' => 'array',
            'rules' => 'array',
            'retreat_cost' => 'array',
            'ancient_trait' => 'array',
            'abilities' => 'array',
            'attacks' => AsCollection::class,
            'weaknesses' => 'array',
            'resistances' => 'array',
            'national_pokedex_numbers' => 'array',
            'legalities' => 'array',
            'images' => 'array',
        ];
    }
}
