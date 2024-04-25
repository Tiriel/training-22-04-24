<?php

namespace App\Movie\Search\Transformer;

use App\Entity\Movie;

class OmdbToMovieTransformer implements OmdbTransformerInterface
{
    private const KEYS = [
        'Title',
        'Plot',
        'Country',
        'Released',
        'Year',
        'Poster',
        'imdbID',
        'Rated',
    ];

    public function transform(mixed $datum): Movie
    {
        if (!\is_array($datum)
            || 0 < \count(\array_diff(self::KEYS, \array_keys($datum)))
        ) {
            throw new \InvalidArgumentException();
        }

        $date = $datum['Released'] === 'N/A' ? $datum['Year'] : $datum['Released'];

        return (new Movie())
            ->setTitle($datum['Title'])
            ->setPlot($datum['Plot'])
            ->setCountry($datum['Country'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setPoster($datum['Poster'])
            ->setPrice(5.0)
            ->setRated($datum['Rated'])
            ->setImdbId($datum['imdbID'])
        ;
    }
}
