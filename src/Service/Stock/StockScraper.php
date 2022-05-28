<?php

namespace App\Service\Stock;

use App\Service\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

abstract class StockScraper implements ScraperInterface
{
    /**
     * @var Crawler
     */
    protected Crawler $crawler;

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param string $html
     * @return void
     */
    public function addHtml(string $html): void
    {
        $this->crawler->add($html);
    }
}