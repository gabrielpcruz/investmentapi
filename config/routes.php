<?php

use Slim\App;

use App\Http\Site\Home;
use App\Http\Api\Stokcs;

return function (App $app) {
    // Site
    $app->get('/', [Home::class, 'index']);

    // Api
    $app->get('/api/v1/stocks/{stock}', [Stokcs::class, 'show']);
};
