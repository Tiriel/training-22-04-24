<?php

class Admin extends Member
{
    protected static int $counter = 0;

    public function __construct(
        string $name,
        string $login,
        string $password,
        int $age,
        protected AdminLevel $level = AdminLevel::Admin
    ) {
        parent::__construct($name, $login, $password, $age);
    }

    public function auth(string $login, string $password): bool
    {
        if ($this->level === AdminLevel::SuperAdmin) {
            return true;
        }

        return parent::auth($login, $password);
    }
}
