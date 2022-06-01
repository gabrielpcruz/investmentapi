<?php

use App\Http\Api\Funds;
use Slim\App;

use App\Http\Site\Documentation;
use App\Http\Api\Stokcs;

return function (App $app) {
    // Site
    $app->redirect('/', '/docs', 300);

    $app->get('/docs', [Documentation::class, 'index']);


    // Stocks
    $app->get('/v1/stocks/{stock}', [Stokcs::class, 'show']);

    // Funds
    $app->get('/v1/funds/{fund}', [Funds::class, 'show']);
};
