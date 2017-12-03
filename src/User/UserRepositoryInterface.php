<?php

namespace Otus\User;


interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function getUsers(): array;
}