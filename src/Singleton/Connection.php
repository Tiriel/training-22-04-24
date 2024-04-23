<?php

namespace App\Singleton;

class Connection
{
    protected \PDO $_pdo;

    protected static ?self $instance = null;

    private function __construct(string $dsn)
    {
        $this->_pdo = new \PDO($dsn);
    }

    private function __clone(): void
    {
    }

    public static function get(string $dsn = null): static
    {
        if (null === static::$instance && null === $dsn) {
            throw new \InvalidArgumentException();
        }

        return static::$instance ??= new static($dsn);
    }
}
