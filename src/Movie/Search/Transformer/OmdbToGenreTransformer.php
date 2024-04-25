<?php

namespace App\Movie\Search\Transformer;

use App\Entity\Genre;

class OmdbToGenreTransformer implements OmdbTransformerInterface
{
    public function transform(mixed $datum): Genre
    {
        if (!\is_string($datum) || str_contains($datum, ',')) {
            throw new \InvalidArgumentException();
        }

        return (new Genre())->setName($datum);
    }
}
