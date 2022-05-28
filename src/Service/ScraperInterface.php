<?php

namespace App\Service;

interface ScraperInterface
{
    /**
     * @param string $html
     * @return void
     */
    public function addHtml(string $html) : void;

    /**
     * @return string
     */
    public function price(): string;

    /**
     * @return string
     */
    public function dividendYield(): string;

    /**
     * @return string
     */
    public function priceByProfit(): string;

    /**
     * @return string
     */
    public function ebitda(): string;

    /**
     * @return string
     */
    public function priceByStock() : string;
}