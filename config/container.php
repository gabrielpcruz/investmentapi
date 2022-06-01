<?php

use Adbar\Dot;
use App\Factory\SlachTraceFactory;
use App\Service\Fund\FundSearcher;
use App\Service\Stock\StatusInvestFundScraper;
use App\Service\Stock\StockScraper;
use App\Service\Stock\StockSearcher;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use SlashTrace\SlashTrace;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Symfony\Component\DomCrawler\Crawler;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use function DI\factory;


return [

    'settings' => function () {
        $settings = require __DIR__ . '/settings.php';

        return new Dot($settings);
    },

    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        // Adding routes of application
        (require __DIR__ . '/routes.php')($app);

        $app->addRoutingMiddleware();

        return $app;
    },

    Twig::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');

        $rootPath = $settings->get('view.path');
        $templates = $settings->get('view.templates');
        $settings = $settings->get('view.settings');


        $loader = new FilesystemLoader([], $rootPath);

        foreach ($templates as $namespace => $template) {
            $loader->addPath($template, $namespace);
        }

        $twig = new Twig($loader, $settings);

        $twig->addExtension(new DebugExtension());

        return $twig;
    },

    SlashTrace::class => factory([
        SlachTraceFactory::class,
        'create',
    ]),

    Crawler::class => function(ContainerInterface $container) {
        return new Crawler();
    },

    StockSearcher::class => function(ContainerInterface $container) {
        $settings = $container->get('settings');

        $sites =  $settings->get('sites_scraping.stocks');

        shuffle($sites);

        $client = new Client([
            'base_uri' => reset($sites),
            'headers' => $settings->get('sites_scraping.headers')
        ]);

        return new StockSearcher($client);
    },

    FundSearcher::class => function(ContainerInterface $container) {
        $settings = $container->get('settings');

        $sites =  $settings->get('sites_scraping.funds');

        shuffle($sites);

        $client = new Client([
            'base_uri' => reset($sites),
            'headers' => $settings->get('sites_scraping.headers')
        ]);

        return new FundSearcher($client);
    },

    StatusInvestFundScraper::class => function(ContainerInterface $container) {
        $crawler = $container->get(Crawler::class);

        return new StatusInvestFundScraper($crawler);
    },

];
