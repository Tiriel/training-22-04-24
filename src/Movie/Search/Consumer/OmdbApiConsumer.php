<?php

namespace App\Movie\Search\Consumer;

use App\Movie\Search\Enum\SearchType;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias]
class OmdbApiConsumer implements OmdbApiConsumerInterface
{
    public function __construct(
        protected readonly HttpClientInterface $omdbClient,
    )
    {
    }

    public function fetch(SearchType $type, string $value): array
    {
        $data = $this->omdbClient->request(
            'GET',
            '',
            [
                'query' => [
                    $type->getLabel() => $value
                ]
            ]
        )->toArray();

        if (\array_key_exists('Error', $data)) {
            if ('Movie not found!' === $data['Error']) {
                throw new NotFoundHttpException('Movie not found!');
            }
            throw new \RuntimeException('Error : '.$data['Error']);
        }

        return $data;
    }
}
