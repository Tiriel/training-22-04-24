<?php

namespace App\User;

use App\Auth\Exception\AuthException;
use App\Auth\Interface\AuthInterface;

class Member extends User implements AuthInterface
{
    protected static int $counter = 0;

    public function __construct(
        string $name,
        protected string $login,
        protected string $password,
        protected int $age,
    ) {
        parent::__construct($name);
        static::$counter++;
    }

    public function __destruct()
    {
        static::$counter--;
    }

    public function auth(string $login, string $password): bool
    {
        if ($this->login !== $login || $this->password !== $password) {
            throw new AuthException($login);
        }

        return true;
    }

    public static function count(): int
    {
        return static::$counter;
    }
}
