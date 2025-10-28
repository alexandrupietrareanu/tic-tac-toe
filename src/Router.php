<?php

declare(strict_types=1);

namespace App;

use App\Controller\ControllerInterface;

class Router
{
    /**
     * @throws \Exception
     */
    public function dispatch(string $path): void
    {
        // Remove trailing slash & sanitize
        $path = trim($path, '/');
        $segments = '' === $path ? [] : explode('/', $path);

        // Default route
        $controllerName = $segments[0] ?? 'home';
        $method = $segments[1] ?? 'index';
        $params = \array_slice($segments, 2); // URL parameters after method

        $controllerClass = 'App\Controller\\'.ucfirst($controllerName).'Controller';

        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo "Controller '{$controllerClass}' not found";

            return;
        }

        /** @var ControllerInterface $controller */
        $controller = $this->resolve($controllerClass);

        if (!method_exists($controller, $method)) {
            http_response_code(404);
            echo "Method '{$method}' not found in controller '{$controllerClass}'";

            return;
        }

        // Static analysis now knows this is a callable
        $callable = [$controller, $method];
        \assert(\is_callable($callable));

        \call_user_func_array($callable, $params);
    }

    private function resolve(string $class): object
    {
        /** @var class-string $class */
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $dependencies = array_map(function (\ReflectionParameter $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                $depClass = $type->getName();

                return $this->resolve($depClass);
            }

            if ($param->isDefaultValueAvailable()) {
                return $param->getDefaultValue();
            }

            throw new \Exception("Cannot resolve parameter '{$param->getName()}' for {$param->getDeclaringClass()?->getName()}");
        }, $constructor->getParameters());

        return $reflection->newInstanceArgs($dependencies);
    }
}
