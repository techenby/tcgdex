<?php

namespace App;

use App\Models\Card;
use App\Models\Set;
use Illuminate\Support\Str;

class PtcgoImporter
{
    public static function getCards($import)
    {
        $data = collect(explode("\n", $import))
            ->filter(fn ($line) => ! Str::contains($line, ['Trainer:', 'Energy:', 'Total', 'Pokémon:'])
                && ! empty($line)
            )
            ->map(function ($line) {
                $split = explode(' ', $line);

                return [
                    // take the count off of the beginning
                    'count' => array_shift($split),
                    // take the card number off of the end
                    'number' => array_pop($split),
                    // take the set off of the end
                    'set' => array_pop($split),
                    // combine the rest
                    'name' => implode(' ', $split),
                ];
            });

        $sets = Set::whereIn('ptcgo_code', $data->pluck('set'))->get();

        return $data->map(function ($data) use ($sets) {
            $card = Card::select('id')->where('set_id', $sets->firstWhere('ptcgo_code', $data['set'])->id)
                ->whereNumber($data['number'])
                ->first();

            return [
                'count' => (int) $data['count'],
                'card_id' => $card->id,
            ];
        })->map(function ($item) {
            if ($item['count'] === 1) {
                return [$item['card_id']];
            }

            $ids = [];
            for ($i = 0; $i < $item['count']; $i++) {
                $ids[] = $item['card_id'];
            }

            return $ids;
        })
            ->flatten();
    }
}
