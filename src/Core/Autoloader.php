<?php

declare(strict_types=1);

namespace App\Core;

class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function ($class) {
            $baseDir = __DIR__.'/../';
            $file = $baseDir.str_replace('\\', '/', $class).'.php';
            if (file_exists($file)) {
                require $file;
            }
        });
    }
}
