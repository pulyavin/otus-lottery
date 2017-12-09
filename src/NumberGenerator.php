<?php

namespace Otus;


class NumberGenerator
{
    /**
     * @var int
     */
    private $seed;

    /**
     * Seed setter
     *
     * @param int $seed
     */
    public function setSeed(int $seed)
    {
        $this->seed = $seed;
    }

    /**
     * Returns random numbers
     *
     * @param int $usersCount
     * @param int $count
     *
     * @return array
     */
    public function getNumbers(int $usersCount, int $count): array
    {
        $result = [];

        if (!empty($this->seed)) {
            mt_srand($this->seed);
        }

        do {
            $rand = mt_rand(0, $usersCount - 1);
            $result[$rand] = true;
        } while (\count($result) < $count);

        return array_keys($result);
    }
}