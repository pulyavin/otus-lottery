<?php

namespace Otus\SeedGenerators;

use Symfony\Component\DomCrawler\Crawler;


class CrawlerFactory
{
    /**
     * Returns ready Crawler
     *
     * @param string $content
     * @param string|null $uri
     *
     * @return Crawler
     */
    public function getCrawler(string $content, string $uri = null): Crawler
    {
        return new Crawler($content, $uri);
    }
}