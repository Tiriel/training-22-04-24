<?php

namespace App\Movie\Search\Provider;

use App\Entity\Movie;
use App\Movie\Search\Consumer\OmdbApiConsumerInterface;
use App\Movie\Search\Enum\SearchType;
use App\Movie\Search\Transformer\OmdbToMovieTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class MovieProvider implements ProviderInterface
{
    public function __construct(
        protected EntityManagerInterface $manager,
        protected OmdbApiConsumerInterface $consumer,
        protected OmdbToMovieTransformer $transformer,
        protected GenreProvider $genreProvider,
    ) {
    }

    public function getOne(string $value, SearchType $type = SearchType::Title): ?Movie
    {
        $movie = $this->checkDatabaseForMovie($type, $value);
        if ($movie instanceof Movie) {
            return $movie;
        }

        $data = $this->getDataFromOmdb($type, $value);
        if (null === $data) {
            return $data;
        }

        $movie = $this->transformMovie($data);

        $this->saveMovie($movie);

        return $movie;
    }

    protected function checkDatabaseForMovie(SearchType $type, string $value): ?Movie
    {
        return $this->manager
            ->getRepository(Movie::class)
            ->findLikeOmdb($type, $value);
    }

    protected function getDataFromOmdb(SearchType $type, string $value): ?array
    {
        try {
            return $this->consumer->fetch($type, $value);
        } catch (NotFoundHttpException) {
            return null;
        }
    }

    protected function transformMovie(array $data): Movie
    {
        $movie = $this->transformer->transform($data);

        $genres = $this->genreProvider->getFromOmdbString($data['Genre']);
        foreach ($genres as $genre) {
            $movie->addGenre($genre);
        }

        return $movie;
    }

    protected function saveMovie(Movie $movie): void
    {
        $this->manager->persist($movie);
        $this->manager->flush();
    }
}
