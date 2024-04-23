<?php

namespace App\Decorator;

use App\Consumer\OmdbApiConsumer;
use Psr\Log\LoggerInterface;

class LoggableOmdbApiConsumer extends OmdbApiConsumer
{
    public function __construct(
        protected OmdbApiConsumer $inner,
        protected LoggerInterface $logger,
    )
    {
    }

    public function fetchMovie(string $title): array
    {
        $this->logger->info(sprintf('Searching for a movie called "%s"', $title));

        return $this->inner->fetchMovie($title);
    }
}
