<?php

namespace App\Http\Integrations\PokemonTcg;

use Saloon\Http\Auth\HeaderAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\PaginationPlugin\Paginator;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\PagedPaginator;

class PokemonTcg extends Connector implements HasPagination
{
    use AcceptsJson;

    public function resolveBaseUrl(): string
    {
        return 'https://api.pokemontcg.io/v2/';
    }

    public function paginate(Request $request): Paginator
    {
        return new class(connector: $this, request: $request) extends PagedPaginator
        {
            protected function isLastPage(Response $response): bool
            {
                return $response->json('count') < $response->json('pageSize');
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $response->json('data');
            }
        };
    }

    protected function defaultAuth(): HeaderAuthenticator
    {
        return new HeaderAuthenticator(config('services.pokemon_tcg.key'), 'X-API-KEY');
    }
}
