<?php

namespace App\Http\Api;

use App\Http\ControllerApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\DomCrawler\Crawler;

class Stokcs extends ControllerApi
{
    /**
     * @var Crawler
     */
    private Crawler $crawler;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @param Crawler $crawler
     * @param Client $client
     */
    public function __construct(Crawler $crawler, Client $client)
    {
        $this->crawler = $crawler;
        $this->client = $client;
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

        try {
            $requestHtml = $this->client->get(strtolower($ticker));

            $stream = $requestHtml->getBody();
            $html = $stream->getContents();
            $stream->detach();
            $this->crawler->add($html);
            $price = $this->crawler->filter("div[title='Valor atual do ativo'] > strong");
            $dy = $this->crawler->filter("div[title='Indicador utilizado para relacionar os proventos pagos por uma companhia e o preço atual de suas ações.']");
            $pl = $this->crawler->filter("div[title='Dá uma ideia do quanto o mercado está disposto a pagar pelos lucros da empresa.']");
            $ebtd = $this->crawler->filter("div[title='O EV (Enterprise Value ou Valor da Firma), indica quanto custaria para comprar todos os ativos da companhia, descontando o caixa. Este indicador mostra quanto tempo levaria para o valor calculado no EBITDA pagar o investimento feito para compra-la.']");

            $stock = [
                'ticker' => strtoupper($ticker),
                'price' => str_replace(',', '.', $price->text()),
                'dividend_yield' => $dy->first()->filter('strong')->text(),
                'pl' => $pl->first()->filter('strong')->text(),
                'evebitda' => $ebtd->first()->filter('strong')->text(),
            ];

        } catch (\Throwable $exception) {
            $stock = [
                'message' => 'error'
            ];
        }


        return $this->responseJSON($response, $stock);
    }
}