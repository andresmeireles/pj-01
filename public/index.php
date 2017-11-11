<?php

use \Slim\App;
use \Dotenv\Dotenv;
use \Tracy\Debugger;   
session_start();

require __DIR__.'/../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__.'/..');
$dotenv->load();

Debugger::enable(Debugger::DEVELOPMENT);
// slim settings
$settings = require __DIR__."/../src/settings.php";
$app = new App($settings);

// to use trancy error handler
unset($app->getContainer()['errorHandler']);

// dependencies
require __DIR__."/../src/dependencies.php";

// middleware	
require __DIR__.'/../src/middleware.php';

//routes
require __DIR__."/../src/routes.php";
$app->run();