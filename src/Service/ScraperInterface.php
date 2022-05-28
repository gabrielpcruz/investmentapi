<?php

namespace App\Service;

interface ScraperInterface
{
    /**
     * @param string $html
     * @return void
     */
    public function addHtml(string $html) : void;
}