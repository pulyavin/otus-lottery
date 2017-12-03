<?php

namespace Otus\Commands;

use Otus\CsvParser;
use Otus\EmailObfuscator;
use Otus\User\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ObfuscatorCommand extends Command
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EmailObfuscator
     */
    private $emailObfuscator;

    /**
     * @var CsvParser
     */
    private $csvParser;

    /**
     * @var string
     */
    private $csvPath;

    /**
     * ObfuscatorCommand constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param EmailObfuscator $emailObfuscator
     * @param CsvParser $csvParser
     * @param string $csvPath
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        EmailObfuscator $emailObfuscator,
        CsvParser $csvParser,
        string $csvPath
    )
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->emailObfuscator = $emailObfuscator;
        $this->csvParser = $csvParser;
        $this->csvPath = $csvPath;
    }

    protected function configure()
    {
        $this
            ->setName('obfuscator')
            ->setDescription('Obfuscate a csv file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $users = $this->userRepository->getUsers();

            $lines = [];
            foreach ($users as $user) {
                $lines[] = [
                    $this->emailObfuscator->obfuscate($user->getEmail())
                ];
            }

            $this->csvParser->storeLines($this->csvPath, $lines);
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
        }
    }
}