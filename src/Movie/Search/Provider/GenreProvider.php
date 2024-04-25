<?php

namespace App\Movie\Search\Provider;

use App\Entity\Genre;
use App\Movie\Search\Transformer\OmdbToGenreTransformer;
use App\Repository\GenreRepository;

readonly class GenreProvider implements ProviderInterface
{
    public function __construct(
        protected GenreRepository $repository,
        protected OmdbToGenreTransformer $transformer,
    ) {
    }

    public function getOne(string $value): Genre
    {
        return $this->repository->findOneBy(['name' => $value])
            ?? $this->transformer->transform($value);
    }

    public function getFromOmdbString(string $names): iterable
    {
        foreach (explode(', ', $names) as $name) {
            yield $this->getOne($name);
        }
    }
}
