<?php

namespace App\Factory;

use App\App;
use App\Service\Fund\FundsExplorerFundScraper;
use App\Service\ScraperInterface;
use App\Service\Stock\StatusInvestFundScraper;
use App\Service\Stock\SunoStockScraper;
use DI\DependencyException;
use DI\NotFoundException;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ScraperFactory
{
    /**
     * @var array|string[]
     */
    private static array $scrapers = [
        'statusinvest.com.br' => StatusInvestFundScraper::class,
        'www.suno.com.br' => SunoStockScraper::class,
        'www.fundsexplorer.com.br' => FundsExplorerFundScraper::class,
    ];

    /**
     * @param $uri
     * @return string
     */
    private static function getScraperByUri($uri): string
    {
        if (in_array($uri, self::$scrapers)) {
            throw new InvalidArgumentException("Improve a valid uri");
        }

        return self::$scrapers[$uri];
    }

    /**
     * @param $uri
     * @return ScraperInterface
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public static function buildByUri($uri) : ScraperInterface
    {
        $scraperClass = self::getScraperByUri($uri);

        return App::getInstace()->getContainer()->get($scraperClass);
    }
}