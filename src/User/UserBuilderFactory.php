<?php

namespace Otus\User;


class UserBuilderFactory
{
    /**
     * Returns UserBuilder instance
     *
     * @return UserBuilder
     */
    public function getBuilder(): UserBuilder
    {
        return new UserBuilder();
    }
}