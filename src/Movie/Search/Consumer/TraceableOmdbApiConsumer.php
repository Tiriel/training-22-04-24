<?php

namespace App\Movie\Search\Consumer;

use App\Movie\Search\Enum\SearchType;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(OmdbApiConsumerInterface::class, priority: 10)]
class TraceableOmdbApiConsumer implements OmdbApiConsumerInterface
{
    public function __construct(
        protected readonly OmdbApiConsumerInterface $inner,
        protected readonly LoggerInterface $logger,
    )
    {
    }

    public function fetch(SearchType $type, string $value): array
    {
        $this->logger->log('info', sprintf('Featching data from OMDb API : %s = "%s"',
            $type->getLabel(),
            $value
        ));

        return $this->inner->fetch($type, $value);
    }
}
