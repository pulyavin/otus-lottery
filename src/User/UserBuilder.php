<?php

namespace Otus\User;


class UserBuilder
{
    /**
     * @var string
     */
    private $email;

    /**
     * Sets user email
     *
     * @param string $email
     *
     * @return UserBuilder
     */
    public function setEmail(string $email): UserBuilder
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Builds user DTO
     *
     * @return User
     */
    public function build(): User
    {
        return new User(
            $this->email
        );
    }
}