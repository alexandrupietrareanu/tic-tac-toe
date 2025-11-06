<?php

declare(strict_types=1);

namespace App;

use App\Controller\ControllerInterface;

class Router
{
    /** @var array<mixed> */
    private array $routes = [];

    /**
     * @param array<callable> $handler
     */
    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    /**
     * @param array<callable> $handler
     */
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

            if (!is_a($controllerClass, ControllerInterface::class, true)) {
                http_response_code(500);
                echo "Controller '{$controllerClass}' must implement ControllerInterface";

                return;
            }

            /** @var class-string<ControllerInterface> $controllerClass */
            $controller = $this->resolve($controllerClass);

            if (!method_exists($controller, $controllerMethod)) {
                http_response_code(500);
                echo "Method '{$controllerMethod}' not found in controller.";

                return;
            }

            $controller->{$controllerMethod}();

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

        if (!is_a($controllerClass, ControllerInterface::class, true)) {
            http_response_code(500);
            echo "Controller '{$controllerClass}' must implement ControllerInterface";

            return;
        }

        /** @var class-string<ControllerInterface> $controllerClass */
        $controller = $this->resolve($controllerClass);

        if (!method_exists($controller, $methodName)) {
            http_response_code(404);
            echo "Method '{$methodName}' not found in controller '{$controllerClass}'";

            return;
        }

        $controller->{$methodName}(...$params);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T
     */
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
                /** @var class-string<ControllerInterface> $dependencyClass */
                $dependencyClass = $type->getName();

                return $this->resolve($dependencyClass);
            }

            if ($param->isDefaultValueAvailable()) {
                return $param->getDefaultValue();
            }

            throw new \Exception("Cannot resolve {$param->getName()} for {$param->getDeclaringClass()?->getName()}");
        }, $constructor->getParameters());

        return $reflection->newInstanceArgs($dependencies);
    }
}
