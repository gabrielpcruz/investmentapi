<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\InvalidArgumentException;

class Searcher implements SearcherInterface
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var string
     */
    private string $uri = '';

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $uri
     * @return SearcherInterface
     */
    public function addUri(string $uri): SearcherInterface
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function search(): string
    {
        if (!$this->uri) {
            throw new InvalidArgumentException("Needed provid the uri");
        }

        $request = $this->client->get(strtolower($this->uri));
        $response = $request->getBody()->getContents();
        $request->getBody()->detach();

        return $response;
    }

    /**
     * @return string
     */
    public function baseUri(): string
    {
        return $this->client->getConfig('base_uri')->getHost();
    }
}