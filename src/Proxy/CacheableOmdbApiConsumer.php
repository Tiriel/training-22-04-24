<?php

namespace App\Proxy;

use App\Consumer\OmdbApiConsumer;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\CacheInterface;

class CacheableOmdbApiConsumer extends OmdbApiConsumer
{
    public function __construct(
        protected OmdbApiConsumer $inner,
        protected CacheInterface $cache,
    )
    {
    }

    public function fetchMovie(string $title): array
    {
        $sanitized = htmlspecialchars($title);
        $key = sprintf("t_%s", $sanitized);

        return $this->cache->get(
            $key,
            function (CacheItem $i) use ($title) {
                echo "Not cached!\n";
                $i->expiresAfter(3600);

                return $this->inner->fetchMovie($title);
            }
        );
    }
}
