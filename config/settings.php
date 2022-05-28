<?php

// Configure defaults for the whole application.

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['tests'] = $settings['root'] . '/tests';
$settings['public'] = $settings['root'] . '/public';

$settings['error'] = [
    'slashtrace' => 1, // Exibir erros com uma interface gráfica
    'error_reporting' => 1,
    'display_errors' => 1,
    'display_startup_errors' => 1,
];

$settings['timezone'] = 'America/Sao_Paulo';

$settings['view'] = [
    'path' => $settings['root'] . '/resources/views',

    'templates' => [
        "error" => $settings['root'] . '/resources/views/error',
        "console" => $settings['root'] . '/resources/views/console',
        "site" => $settings['root'] . '/resources/views/site',
        "email" => $settings['root'] . '/resources/views/email',
        "layout" => $settings['root'] . '/resources/views/layout',
    ],

    'settings' => [
        'cache' => $settings['root'] . '/storage/cache/views',
        'debug' => true,
        'auto_reload' => true,
    ],
];

$settings['sites_scraping'] = [
    'stocks' => [
        'https://statusinvest.com.br/acoes/',
//        'https://www.suno.com.br/acoes/',
    ],

    'funds' => [
        'https://www.fundsexplorer.com.br/funds/'
    ],

    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Allow-Headers' => 'Content-Type',
        'Access-Control-Max-Age' => '3600',
    ]
];

return $settings;