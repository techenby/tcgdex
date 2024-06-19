<?php

namespace App\Http\Integrations\PokemonTcg;

use Saloon\Http\Auth\HeaderAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class PokemonTcg extends Connector
{
    use AcceptsJson;

    public function resolveBaseUrl(): string
    {
        return 'https://api.pokemontcg.io/v2/';
    }

    protected function defaultAuth(): HeaderAuthenticator
    {
        return new HeaderAuthenticator(config('services.pokemon_tcg.key'), 'X-API-KEY');
    }
}
