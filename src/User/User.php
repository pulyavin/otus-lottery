<?php

namespace Otus\User;


class User
{
    /**
     * @var string
     */
    private $email;

    /**
     * User constructor.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Returns obfuscated email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}