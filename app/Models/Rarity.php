<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function findOrCreate($name)
    {
        return static::firstOrCreate(['name' => $name]);
    }
}
