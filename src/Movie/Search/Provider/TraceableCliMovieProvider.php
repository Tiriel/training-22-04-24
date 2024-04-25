<?php

namespace App\Movie\Search\Provider;

use App\Entity\Movie;
use App\Movie\Search\Enum\SearchType;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Exclude;

#[Exclude]
class TraceableCliMovieProvider extends MovieProvider
{
    protected ?SymfonyStyle $io = null;

    public function __construct(
        protected readonly MovieProvider $inner,
    )
    {
    }

    public function setIo(?SymfonyStyle $io): void
    {
        $this->io = $io;
    }

    protected function checkDatabaseForMovie(SearchType $type, string $value): ?Movie
    {
        $this->io?->text('Searching in database...');

        $movie = $this->inner->checkDatabaseForMovie($type, $value);

        if ($movie instanceof Movie) {
            $this->io?->note('Movie already in database!');
        }

        return $movie;
    }


    protected function getDataFromOmdb(SearchType $type, string $value): ?array
    {
        $this->io?->text('Not found. Searching on OMDb API.');

        return $this->inner->getDataFromOmdb($type, $value);
    }

    protected function transformMovie(array $data): Movie
    {
        $this->io?->note('Found on OMDb!');

        return $this->inner->transformMovie($data);
    }

    protected function saveMovie(Movie $movie): void
    {
        $this->io?->text('Saving movie in database...');
        $this->inner->saveMovie($movie);
    }
}
