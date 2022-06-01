<?php

namespace App\Http\Api;

use App\Builder\ScraperBuilder;
use App\Http\ControllerApi;
use App\Service\Stock\StockSearcher;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Stokcs extends ControllerApi
{
    /**
     * @var StockSearcher
     */
    private StockSearcher $stockSearcher;

    /**
     * @param StockSearcher $stockSearcher
     */
    public function __construct(StockSearcher $stockSearcher)
    {
        $this->stockSearcher = $stockSearcher;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $ticker
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function show(Request $request, Response $response, $ticker): Response
    {
        $ticker = reset($ticker);

        $html = $this->stockSearcher->addUri($ticker)->search();

        $baseUri = $this->stockSearcher->baseUri();

        $scraper = ScraperBuilder::buildByUri($baseUri);

        $scraper->addHtml($html);

        $stock = [
            'font' => $baseUri,
            'ticker' => strtoupper($ticker),
            'price' => $scraper->price(),
            'valuation' => [
                'dividend_yield' => $scraper->dividendYield(),
                'price_by_pofit' => $scraper->priceByProfit(),
                'evebitda' => $scraper->ebitda(),
                'price_by_stock' => $scraper->priceByStock(),
            ],
            'indebtedness' => [
                ''
            ]
        ];

        return $this->responseJSON($response, $stock);
    }
}