<?php

namespace App\User;
abstract class User
{
    public function __construct(protected string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }
}
