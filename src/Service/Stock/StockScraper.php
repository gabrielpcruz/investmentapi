<?php

namespace App\Service\Stock;

use App\Service\Scraper;

class StockScraper extends Scraper
{
    private const PRICE = "div[title='Valor atual do ativo'] > strong";
    private const DIVIDEND_YIELD = "div[title='Indicador utilizado para relacionar os proventos pagos por uma companhia e o preço atual de suas ações.']";
    private const PRICE_BY_PROFIT = "div[title='Dá uma ideia do quanto o mercado está disposto a pagar pelos lucros da empresa.']";
    private const EBITDA = "div[title='O EV (Enterprise Value ou Valor da Firma), indica quanto custaria para comprar todos os ativos da companhia, descontando o caixa. Este indicador mostra quanto tempo levaria para o valor calculado no EBITDA pagar o investimento feito para compra-la.']";

    /**
     * @return string
     */
    public function price(): string
    {
        $price = $this->crawler->filter(self::PRICE);

        return str_replace(',', '.', $price->text());
    }

    /**
     * @return string
     */
    public function dividendYield(): string
    {
        $dividendYield = $this->crawler->filter(self::DIVIDEND_YIELD);

        return $dividendYield->first()->filter('strong')->text();
    }

    /**
     * @return string
     */
    public function priceByProfit(): string
    {
        $priceByProfit = $this->crawler->filter(self::PRICE_BY_PROFIT);

        return $priceByProfit->first()->filter('strong')->text();
    }

    /**
     * @return string
     */
    public function ebitda(): string
    {
        $ebitda = $this->crawler->filter(self::EBITDA);

        return $ebitda->first()->filter('strong')->text();
    }
}