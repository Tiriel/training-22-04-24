<?php

namespace Auth\Exception;
class AuthException extends \RuntimeException
{
    public function __construct(string $login)
    {
        $message = sprintf("Login failed for username %s", $login);

        parent::__construct($message);
    }

}
