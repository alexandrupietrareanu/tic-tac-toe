<?php

declare(strict_types=1);

use App\Autoloader;
use App\Router;

require __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../src/Autoloader.php';

Autoloader::register();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router();
$router->dispatch($path);
