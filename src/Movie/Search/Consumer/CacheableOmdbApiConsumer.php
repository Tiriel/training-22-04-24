<?php

namespace App\Movie\Search\Consumer;

use App\Movie\Search\Enum\SearchType;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[When('prod')]
#[AsDecorator(OmdbApiConsumerInterface::class, priority: 5)]
class CacheableOmdbApiConsumer implements OmdbApiConsumerInterface
{
    public function __construct(
        protected readonly OmdbApiConsumerInterface $inner,
        protected readonly CacheInterface $cache,
        protected readonly SluggerInterface $slugger,
    )
    {
    }

    public function fetch(SearchType $type, string $value): array
    {
        $slug = $this->slugger->slug($value);
        $key = sprintf("%s_%s", $type->getLabel(), $slug);

        return $this->cache->get(
            $key,
            function (CacheItem $item) use ($type, $value) {
                $item->expiresAfter(3600);

                return $this->inner->fetch($type, $value);
            }
        );
    }
}
