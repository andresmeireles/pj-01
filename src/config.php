<?php
use Interop\Container\ContainerInterface;

return [
    'settings.displayErrorDetails' => true,
    'settings.responseChunkSize' => 4096,
    'settings.outputBuffering' => 'append',
    'settings.determineRouteBeforeAppMiddleware' => false,

    \Slim\Views\Twig::class=> function (ContainerInterface $container) {
        $twig = new \Slim\Views\Twig(__DIR__.'/../view/', [
            'cache' => false
        ]);

        $twig->addExtension(new \Slim\Views\TwigExtension(
            $container->get('router'),
            $container->get('request')->getUri()
        ));

        return $twig;
    },

    'CheckAuthMiddleware' => function (ContainerInterface $container) {
        return new \App\Middleware\CheckAuthMiddleware($container->get(\Slim\Views\Twig::class), $container->get('Auth'));
    },

    'Auth' => function (ContainerInterface $container) {
        $auth = new \App\Auth\Auth;
        return $auth;
    },
];