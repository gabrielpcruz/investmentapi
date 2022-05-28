<?php

namespace App\Http\Api;

use App\Http\ControllerApi;
use App\Service\Fund\FundSearcher;

class Funds extends ControllerApi
{
    private FundSearcher $fundSearcher;

    public function __construct(FundSearcher $fundSearcher)
    {
        $this->fundSearcher = $fundSearcher;
    }
}