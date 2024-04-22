<?php

class Member
{
    public function __construct(
        protected string $login,
        protected string $password,
        protected int $age,
    )
    {
    }

    public function auth(string $login, string $password): bool
    {
        return $this->login === $login && $this->password === $password;
    }
}
