<?php

namespace App\Service;

interface SearcherInterface
{
    /**
     * @param string $uri
     * @return SearcherInterface
     */
    public function addUri(string $uri): SearcherInterface;

    /**
     * @return string
     */
    public function search(): string;

    /**
     * @return string
     */
    public function baseUri() : string;
}