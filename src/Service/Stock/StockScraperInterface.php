<?php

namespace App\Service\Stock;

interface StockScraperInterface
{
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