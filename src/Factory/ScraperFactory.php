<?php

namespace App\Factory;

use App\Service\Stock\StatusInvestStockScraper;
use InvalidArgumentException;

class ScraperFactory
{
    /**
     * @var array|string[]
     */
    private static array $scrapers = [
        'statusinvest.com.br' => StatusInvestStockScraper::class
    ];

    /**
     * @param $uri
     * @return string
     */
    public static function getScraperByUri($uri): string
    {
        if (in_array($uri, self::$scrapers)) {
            throw new InvalidArgumentException("Improve a valid uri");
        }

        return self::$scrapers[$uri];
    }
}