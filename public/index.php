<?php

declare(strict_types=1);

use App\Core\Autoloader;
use App\Core\Router;

require __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../src/Core/Autoloader.php';

Autoloader::register();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router();
$router->dispatch($path);
