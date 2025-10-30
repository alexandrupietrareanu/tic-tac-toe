<?php

declare(strict_types=1);

namespace App;

use App\Controller\ControllerInterface;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $path): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = trim($path, '/');

        if (isset($this->routes[$method][$path])) {
            [$controllerClass, $controllerMethod] = $this->routes[$method][$path];

            /** @var ControllerInterface $controller */
            $controller = $this->resolve($controllerClass);
            \call_user_func([$controller, $controllerMethod]);

            return;
        }

        // Fallback: old behavior
        $segments = '' === $path ? [] : explode('/', $path);
        $controllerName = $segments[0] ?? 'home';
        $methodName = $segments[1] ?? 'index';
        $params = \array_slice($segments, 2);

        $controllerClass = 'App\Controller\\'.ucfirst($controllerName).'Controller';
        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo "Controller '{$controllerClass}' not found";

            return;
        }

        /** @var ControllerInterface $controller */
        $controller = $this->resolve($controllerClass);
        if (!method_exists($controller, $methodName)) {
            http_response_code(404);
            echo "Method '{$methodName}' not found in controller '{$controllerClass}'";

            return;
        }

        \call_user_func_array([$controller, $methodName], $params);
    }

    private function resolve(string $class): object
    {
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $dependencies = array_map(function (\ReflectionParameter $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                return $this->resolve($type->getName());
            }
            if ($param->isDefaultValueAvailable()) {
                return $param->getDefaultValue();
            }

            throw new \Exception("Cannot resolve {$param->getName()} for {$param->getDeclaringClass()?->getName()}");
        }, $constructor->getParameters());

        return $reflection->newInstanceArgs($dependencies);
    }
}
