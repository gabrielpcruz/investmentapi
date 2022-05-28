<?php

use Slim\App;

use App\Http\Site\Documentation;
use App\Http\Api\Stokcs;

return function (App $app) {
    // Site
    $app->redirect('/', '/docs', 300);

    $app->get('/docs', [Documentation::class, 'index']);


    // Api
    $app->get('/v1/stocks/{stock}', [Stokcs::class, 'show']);
};
