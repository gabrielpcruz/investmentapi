<?php

namespace App\Service\Fund;

class FundsExplorerFundScraper extends FundScraper implements FundScraperInterface
{
    private const PRICE = "#stock-price > .price";
    private const DIVIDEND_YIELD = "div[title='Indicador utilizado para relacionar os proventos pagos por uma companhia e o preço atual de suas ações.']";
    private const PRICE_BY_PROFIT = "div[title='Dá uma ideia do quanto o mercado está disposto a pagar pelos lucros da empresa.']";
    private const EBITDA = "div[title='O EV (Enterprise Value ou Valor da Firma), indica quanto custaria para comprar todos os ativos da companhia, descontando o caixa. Este indicador mostra quanto tempo levaria para o valor calculado no EBITDA pagar o investimento feito para compra-la.']";
    private const PRICE_BY_STOCK = "div[title='Preço da ação dividido pelos Ativos totais por ação.']";

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
        return '';
    }

    /**
     * @return string
     */
    public function priceByProfit(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function ebitda(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function priceByStock(): string
    {
        return '';
    }
}