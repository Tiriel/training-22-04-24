<?php

class Member extends User implements AuthInterface
{
    protected static int $counter = 0;

    public function __construct(
        string $name,
        protected string $login,
        protected string $password,
        protected int $age,
    )
    {
        parent::__construct($name);
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
