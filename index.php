<?php

use App\Consumer\OmdbApiConsumer;
use App\Decorator\LoggableOmdbApiConsumer;
use App\Proxy\CacheableOmdbApiConsumer;
use App\Singleton\Connection;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require_once __DIR__.'/vendor/autoload.php';

$dsn = 'sqlite://'.__DIR__.'/var/data.db';

$connection = Connection::get($dsn);

//$cache = new FilesystemAdapter();
//$logger = new NullLogger();
//$consumer = new CacheableOmdbApiConsumer(
//    new LoggableOmdbApiConsumer(
//        new OmdbApiConsumer(),
//        $logger),
//    $cache);
//$movie = $consumer->fetchMovie($argv[1]);
//
//echo "Titre exact : \n";
//echo $movie['Title']."\n";
//echo "Plot :\n";
//echo $movie['Plot']."\n";
