<?php

namespace App\Movie\Search\Consumer;

use App\Movie\Search\Enum\SearchType;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

interface OmdbApiConsumerInterface
{
    public function fetch(SearchType $type, string $value): array;
}
