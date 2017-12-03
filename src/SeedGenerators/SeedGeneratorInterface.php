<?php

namespace Otus\SeedGenerators;


interface SeedGeneratorInterface
{
    /**
     * Returns seed
     *
     * @return int
     */
    public function getSeed(): int;
}