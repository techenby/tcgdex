<?php

namespace App\Http\Integrations\PokemonTcg\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRaritiesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/rarities';
    }
}
