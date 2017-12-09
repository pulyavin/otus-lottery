<?php

namespace Otus\SeedGenerators;

use Otus\FileSystem;
use Psr\Log\LoggerInterface;


class CrcSeedGenerator implements SeedGeneratorInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $path;

    /**
     * @var FileSystem
     */
    private $fileSystem;

    /**
     * SeedGenerator constructor.
     *
     * @param string $path
     * @param FileSystem $fileSystem
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $path,
        FileSystem $fileSystem,
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
        $this->path = $path;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Returns seed
     *
     * @return int
     */
    public function getSeed(): int
    {
        $this->logger->info("Load content from path {$this->path}");

        $content = $this->fileSystem->getContent($this->path);

        $this->logger->info("Content is {$content}");

        $seed = crc32($content);

        $this->logger->info("Seed is {$seed}");

        return $seed;
    }
}