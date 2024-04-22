<?php

class Admin extends Member
{
    public function __construct(
        string $login,
        string $password,
        int $age,
        protected AdminLevel $level = AdminLevel::Admin
    ) {
        parent::__construct($login, $password, $age);
    }

    public function auth(string $login, string $password): bool
    {
        if ($this->level === AdminLevel::SuperAdmin) {
            return true;
        }

        return parent::auth($login, $password);
    }
}
