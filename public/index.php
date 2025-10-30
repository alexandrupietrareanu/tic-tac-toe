<?php

declare(strict_types=1);

use App\Autoloader;
use App\Controller\HomeController;
use App\Router;

require __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../src/Autoloader.php';

Autoloader::register();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Router();

// GET routes
$router->get('', [HomeController::class, 'index']);
$router->get('home/index', [HomeController::class, 'index']);

// POST routes
$router->post('move', [HomeController::class, 'move']);

$router->dispatch($_SERVER['REQUEST_URI']);
