<?php

namespace App\Service\Stock;

class SunoStockScraper extends StockScraper implements StockScraperInterface
{
    private const PRICE = "div.ticker-value > div";
    private const DIVIDEND_YIELD = "div[title='Indicador utilizado para relacionar os proventos pagos por uma companhia e o preço atual de suas ações.']";
    private const PRICE_BY_PROFIT = "div[title='Dá uma ideia do quanto o mercado está disposto a pagar pelos lucros da empresa.']";
    private const EBITDA = "div[title='O EV (Enterprise Value ou Valor da Firma), indica quanto custaria para comprar todos os ativos da companhia, descontando o caixa. Este indicador mostra quanto tempo levaria para o valor calculado no EBITDA pagar o investimento feito para compra-la.']";
    private const PRICE_BY_STOCK = "div[title='Preço da ação dividido pelos Ativos totais por ação.']";

    /**
     * @return string
     */
    public function price(): string
    {
        $price = $this->crawler->filter(self::PRICE)->first();

        $price = str_replace('R$ ', '', $price->text());

        return str_replace(',', '.', $price);
    }

    /**
     * @return string
     */
    public function dividendYield(): string
    {
        return "";
    }

    /**
     * @return string
     */
    public function priceByProfit(): string
    {
        return "";
    }

    /**
     * @return string
     */
    public function ebitda(): string
    {
        return "";
    }

    /**
     * @return string
     */
    public function priceByStock(): string
    {
        return "";
    }
}