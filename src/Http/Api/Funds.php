<?php

namespace App\Http\Api;

use App\Factory\ScraperFactory;
use App\Http\ControllerApi;
use App\Service\Fund\FundSearcher;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Funds extends ControllerApi
{
    /**
     * @var FundSearcher
     */
    private FundSearcher $fundSearcher;

    /**
     * @param FundSearcher $fundSearcher
     */
    public function __construct(FundSearcher $fundSearcher)
    {
        $this->fundSearcher = $fundSearcher;
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

        $html = $this->fundSearcher->addUri($ticker)->search();

        $baseUri = $this->fundSearcher->baseUri();

        $scraper = ScraperFactory::buildByUri($baseUri);

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