<?php

namespace Otus\SeedGenerators;

use GuzzleHttp\Client;


class ClientFactory
{
    /**
     * Returns Guzzle Http Client
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return new Client();
    }
}