<?php

declare(strict_types=1);

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private static ?Environment $twig = null;

    public static function render(string $template, array $data = [])
    {
        self::init();
        echo self::$twig->render('@view/'.$template.'.twig', $data);
    }

    private static function init()
    {
        if (null === self::$twig) {
            $loader = new FilesystemLoader();

            // Root views namespace
            $loader->addPath(__DIR__.'/../Views', 'view');

            // Layouts namespace
            $loader->addPath(__DIR__.'/../Views/layouts', 'layout');

            self::$twig = new Environment($loader, [
                'cache' => false,
                'debug' => true,
            ]);
        }
    }
}
