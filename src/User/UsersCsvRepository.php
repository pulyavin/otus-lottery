<?php

namespace Otus\User;


class UsersCsvRepository implements UserRepositoryInterface
{
    /**
     * @var array
     */
    private $lines;

    /**
     * @var UserBuilderFactory
     */
    private $userBuilderFactory;

    /**
     * UsersCsvRepository constructor.
     *
     * @param UserBuilderFactory $userBuilderFactory
     * @param array $lines
     */
    public function __construct(
        UserBuilderFactory $userBuilderFactory,
        array $lines
    )
    {
        $this->userBuilderFactory = $userBuilderFactory;
        $this->lines = $lines;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsers(): array
    {
        $users = [];

        foreach ($this->lines as list($email)) {
            if (empty($email)) {
                continue;
            }

            $userBuilder = $this->userBuilderFactory->getBuilder();
            $userBuilder->setEmail($email);

            $users[] = $userBuilder->build();
        }

        return $users;
    }
}