<?php

namespace App\Consumer;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiConsumer
{
    private readonly HttpClientInterface $client;
    public function __construct()
    {
        $this->client = HttpClient::createForBaseUri(
            'http://www.omdbapi.com',
            ['query' => [
                'apikey' => '77e9a2a5',
                'plot' => 'full',
            ]]
        );
    }

    public function fetchMovie(string $title): array
    {
        return $this->client->request(
            'GET',
            '',
            ['query' => ['t' => $title]]
        )->toArray();
    }
}
