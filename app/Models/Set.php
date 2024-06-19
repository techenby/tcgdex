<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function findByExternalId($id)
    {
        return static::firstWhere(['external_id' => $id]);
    }

    protected function casts(): array
    {
        return [
            'release_date' => 'datetime',
            'legalities' => 'array',
            'images' => 'array',
        ];
    }
}
