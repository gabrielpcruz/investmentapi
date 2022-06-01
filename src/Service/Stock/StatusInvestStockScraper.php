<?php

namespace App\Service\Stock;

class StatusInvestStockScraper extends StockScraper implements StockScraperInterface
{
    private const PRICE = "div[title='Valor atual do ativo'] > strong";
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
        $dividendYield = $this->crawler->filter(self::DIVIDEND_YIELD);

        $dividendYield = $dividendYield->first()->filter('strong');

        return str_replace(',', '.', $dividendYield->text());
    }

    /**
     * @return string
     */
    public function priceByProfit(): string
    {
        $priceByProfit = $this->crawler->filter(self::PRICE_BY_PROFIT);

        $priceByProfit = $priceByProfit->first()->filter('strong');

        return str_replace(',', '.', $priceByProfit->text());
    }

    /**
     * @return string
     */
    public function ebitda(): string
    {
        $ebitda = $this->crawler->filter(self::EBITDA);

        $ebitda =  $ebitda->first()->filter('strong');

        return str_replace(',', '.', $ebitda->text());
    }

    /**
     * @return string
     */
    public function priceByStock(): string
    {
        $priceByStock = $this->crawler->filter(self::PRICE_BY_STOCK);

        $priceByStock = $priceByStock->first()->filter('strong');

        return str_replace(',', '.', $priceByStock->text());
    }
}