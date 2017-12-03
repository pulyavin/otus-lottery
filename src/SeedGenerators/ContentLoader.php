<?php

namespace Otus\SeedGenerators;

use Otus\Exceptions\EmptyContentException;
use Otus\Exceptions\StatusCodeException;
use Symfony\Component\DomCrawler\Crawler;


class ContentLoader
{
    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var CrawlerFactory
     */
    private $crawlerFactory;

    /**
     * ContentLoader constructor.
     *
     * @param ClientFactory $clientFactory
     * @param CrawlerFactory $crawlerFactory
     */
    public function __construct(
        ClientFactory $clientFactory,
        CrawlerFactory $crawlerFactory
    )
    {
        $this->clientFactory = $clientFactory;
        $this->crawlerFactory = $crawlerFactory;
    }

    /**
     * Returns ready crawler
     *
     * @param string $url
     *
     * @return Crawler
     *
     * @throws EmptyContentException
     * @throws StatusCodeException
     */
    public function getCrawler(string $url): Crawler
    {
        $client = $this->clientFactory->getClient();

        $request = $client->request(
            'GET',
            $url
        );

        if ($request->getStatusCode() !== 200) {
            throw new StatusCodeException("Status code is {$request->getStatusCode()}");
        }

        $content = $request->getBody();

        if (empty($content)) {
            throw new EmptyContentException('Content is empty');
        }

        return $this->crawlerFactory->getCrawler($content, $url);
    }
}