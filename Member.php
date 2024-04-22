<?php

class Member
{
    protected static int $counter = 0;

    public function __construct(
        protected string $login,
        protected string $password,
        protected int $age,
    )
    {
        static::$counter++;
    }

    public function __destruct()
    {
        static::$counter--;
    }

    public function auth(string $login, string $password): bool
    {
        return $this->login === $login && $this->password === $password;
    }

    public static function count(): int
    {
        return static::$counter;
    }
}
