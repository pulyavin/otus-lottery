<?php

use Psr\Container\ContainerInterface;

$root = dirname(__DIR__);

require "{$root}/vendor/autoload.php";

$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(true);

$builder->addDefinitions([
    'csv.path' => './users.csv',

    'csv.lines' => DI\factory(function (ContainerInterface $container) {
        $csvParser = $container->get(\Otus\CsvParser::class);

        return $csvParser->getLines(
            $container->get('csv.path')
        );
    }),

    \Otus\User\UsersCsvRepository::class => DI\object()
        ->constructor(
            DI\get(\Otus\User\UserBuilderFactory::class),
            DI\get('csv.lines')
        ),
    \Otus\User\UserRepositoryInterface::class => DI\object(\Otus\User\UsersCsvRepository::class),

    \Otus\SeedGenerators\SeedGeneratorInterface::class => DI\object(\Otus\SeedGenerators\HabrSeedGenerator::class),

    \Otus\NumberGenerator::class => DI\factory(function (ContainerInterface $container) {
        $seedGenerator = $container->get(\Otus\SeedGenerators\SeedGeneratorInterface::class);

        return new \Otus\NumberGenerator($seedGenerator->getSeed());
    }),

    Otus\Commands\ObfuscatorCommand::class => DI\object()
        ->constructor(
            DI\get(\Otus\User\UserRepositoryInterface::class),
            DI\get(\Otus\EmailObfuscator::class),
            DI\get(\Otus\CsvParser::class),
            DI\get('csv.path')
        ),

    \Psr\Log\LoggerInterface::class => DI\factory(function (ContainerInterface $container) {
        $logger = new \Monolog\Logger('logger');

        $logger->pushHandler(new Monolog\Handler\ErrorLogHandler);

        return $logger;
    }),
]);

$container = $builder->build();
