<?php

namespace Otus\SeedGenerators;

use Otus\Exceptions\EmptyContentException;
use Otus\Exceptions\StatusCodeException;
use Psr\Log\LoggerInterface;


class HabrSeedGenerator implements SeedGeneratorInterface
{
    /**
     * @var ContentLoader
     */
    private $contentLoader;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SeedGenerator constructor.
     *
     * @param ContentLoader $contentLoader
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContentLoader $contentLoader,
        LoggerInterface $logger
    )
    {
        $this->contentLoader = $contentLoader;
        $this->logger = $logger;
    }

    /**
     * Returns seed
     *
     * @return int
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws StatusCodeException
     * @throws EmptyContentException
     */
    public function getSeed(): int
    {
        $url = 'https://habrahabr.ru/all/';

        $this->logger->debug("Try to load \"{$url}\"");
        $hubCrawler = $this->contentLoader->getCrawler($url);
        $this->logger->debug("Load \"{$url}\" completed");

        $postNode = $hubCrawler->filter('a.post__title_link')->first();

        $postLink = $postNode->link()->getUri();
        $postTitle = $postNode->text();

        $this->logger->debug("Found post \"{$postTitle}\" on \"{$postLink}\"");

        $postCrawler = $this->contentLoader->getCrawler($postLink);

        $content = $postCrawler->filter('.post__body_full')->first()->text();

        $seed = crc32($content);

        $this->logger->debug("Seed is \"{$seed}\"");

        return $seed;
    }
}