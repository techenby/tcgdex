<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Deck extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class)->withPivot('id')->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collection()
    {
        return DB::table('card_deck')
            ->select(DB::raw('card_id, count(*) as count, max(id) as last_id'))
            ->where('deck_id', $this->id)
            ->groupBy('card_id')
            ->get();
    }
}
