<?php

use Adbar\Dot;
use App\Factory\SlachTraceFactory;
use GuzzleHttp\Client;
use SlashTrace\SlashTrace;
use Slim\App;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\DomCrawler\Crawler;
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

    Client::class => function(ContainerInterface $container) {
        return new Client(
            [
                'base_uri' => 'https://statusinvest.com.br/acoes/',
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0',
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods' => 'GET',
                    'Access-Control-Allow-Headers' => 'Content-Type',
                    'Access-Control-Max-Age' => '3600',
                ]
            ]
        );
    }
];
