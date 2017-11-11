<?php
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;
use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
use \Respect\Validation\Validator as v;

// to use custom rules
v::with('App\\Validation\\Rules\\');

$container = $app->getContainer();

// packages
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $renderer = new Twig($settings['template_path'], [false]);

    $basePath = rtrim(str_replace('index.php', '', $c['request']->getUri()->getBasePath()), '/');

    $renderer->addExtension(new TwigExtension($c['router'], $basePath));

    $renderer->getEnvironment()->addFilter($settings['filters']['height']);
    $renderer->getEnvironment()->addFilter($settings['filters']['money']);
    $renderer->getEnvironment()->addFilter($settings['filters']['slug']);
    $renderer->getEnvironment()->addGlobal('flash', $c->flash);

    return $renderer;
};


$container['auth'] = function ($container) {
    return new App\Auth\Auth($container);
};

$container['db'] = function ($c) {
    require __DIR__.'/../config/bootstrap.php';

    return $entityManager;
};

$container['logger'] = function ($container) {
    $settings = $container->get('settings');
    $settings = $settings['monolog'];
    $logger = new \Monolog\Logger('myLog');
    $file_handler = new \Monolog\Handler\StreamHandler($settings['path']);
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['report'] = function ($container) {
    $settings = $container->get('settings')['reports'];
    
    //custom font
    $fontDirConfig = new \Mpdf\Config\ConfigVariables();
    $fontDirConfig = $fontDirConfig->getDefaults();
    $fontDir = $fontDirConfig['fontDir'];

    $fontConfig = new \Mpdf\Config\FontVariables();
    $fontConfig = $fontConfig->getDefaults();
    $fontData = $fontConfig['fontdata'];
    
    $config = array(
        'fontDir' => array_merge($fontDir, [
            __DIR__.'/../reports/fonts/'
        ]),
        'fontdata' => $fontData + [
            'roboto' => [
                'R' => 'Roboto-Thin.ttf',
                'I' => 'Roboto-Regular.ttf',
            ],
        ],
        
        'default_font' => 'roboto'
    );

    $report = new \Mpdf\Mpdf($config);
    return $report;
};

// simples configurable packages
$services = array(
    'validation' => '\App\Validation\Validator',
    'validationJson' => '\App\Validation\ValidatorJson',
    'flash' => '\Slim\Flash\Messages',
    'csrf' => '\Slim\Csrf\Guard',
    'auth' => '\App\Auth\Auth',
);

// controllers and middlewares
$actions = array(
    //Controllers
    'HomeController' => "\App\Controller\HomeController", 
    'RecordController' => 'App\Controller\RecordController',
    'ProductionController' => 'App\Controller\ProductionController',
    'ReportController' => '\App\Controller\ReportController',

    // auth controllers
    'AuthController' => '\App\Controller\Auth\AuthController',
    'PasswordController' => '\App\Controller\Auth\PasswordController',
    
    //Middlewares
    'ValidationErrorsMiddleware' => '\App\Middleware\ValidationErrorsMiddleware',
    'OldInfoMiddleware' => '\App\Middleware\OldInfoMiddleware',
    'CsrfViewMiddleware' => '\App\Middleware\CsrfViewMiddleware',
    'CheckAuthMiddleware' => '\App\Middleware\CheckAuthMiddleware',
    'AuthMiddleware' => '\App\Middleware\AuthMiddleware',
    'GestMiddleware' => '\App\Middleware\GestMiddleware',
);

foreach ($services as $key => $value) {
    $container[$key] = function ($container) use ($key, $value) {
        return new $value;
    };
}

foreach ($actions as $key => $value) {
    $container[$key] = function ($container) use ($key, $value) {
        return new $value($container);
    };
}