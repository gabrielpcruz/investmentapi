<?php

namespace App\Service\Fund;

interface FundScraperInterface
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