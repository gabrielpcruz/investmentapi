<?php

namespace App\Http\Api;

use App\Http\ControllerApi;
use App\Service\Stock\StockScraper;
use App\Service\Stock\StockSearcher;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Stokcs extends ControllerApi
{
    /**
     * @var StockSearcher
     */
    private StockSearcher $stockSearcher;

    /**
     * @var StockScraper
     */
    private StockScraper $stockScraper;

    /**
     * @param StockScraper $stockScraper
     * @param StockSearcher $stockSearcher
     */
    public function __construct(StockScraper $stockScraper, StockSearcher $stockSearcher)
    {
        $this->stockSearcher = $stockSearcher;
        $this->stockScraper = $stockScraper;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $ticker
     * @return Response
     */
    public function show(Request $request, Response $response, $ticker): Response
    {
        $ticker = reset($ticker);

        $html = $this->stockSearcher->addUri($ticker)->search();

        $this->stockScraper->addHtml($html);

        $stock = [
            'ticker' => strtoupper($ticker),
            'price' => $this->stockScraper->price(),
            'valuation' => [
                'dividend_yield' => $this->stockScraper->dividendYield(),
                'price_by_pofit' => $this->stockScraper->priceByProfit(),
                'evebitda' => $this->stockScraper->ebitda(),
                'price_by_stock' => $this->stockScraper->priceByStock(),
            ],
            'indebtedness' => [
                ''
            ]
        ];

        return $this->responseJSON($response, $stock);
    }
}