<?php

namespace Otus\Commands;

use Otus\NumberGenerator;
use Otus\SeedGenerators\SeedGeneratorInterface;
use Otus\User\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class WinnersCommand extends Command
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var NumberGenerator
     */
    private $numberGenerator;

    /**
     * @var SeedGeneratorInterface
     */
    private $seedGenerator;

    /**
     * WinnersCommand constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param NumberGenerator $numberGenerator
     * @param SeedGeneratorInterface $seedGenerator
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        NumberGenerator $numberGenerator,
        SeedGeneratorInterface $seedGenerator
    )
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->numberGenerator = $numberGenerator;
        $this->seedGenerator = $seedGenerator;
    }

    protected function configure()
    {
        $this
            ->setName('winners')
            ->setDescription('Returns winners list');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $table = new Table($output);
            $table
                ->setHeaders(['Winners']);

            $seed = $this->seedGenerator->getSeed();
            $this->numberGenerator->setSeed($seed);

            $users = $this->userRepository->getUsers();

            $randomNumbers = $this->numberGenerator->getNumbers(\count($users), 2);

            $tableRows = [];
            foreach ($randomNumbers as $randomNumber) {
                $user = $users[$randomNumber];

                $tableRows[] = [$user->getEmail()];
            }

            $table->setRows($tableRows);

            $table->render();
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
        }
    }
}