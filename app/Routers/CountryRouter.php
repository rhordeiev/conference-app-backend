<?php

declare(strict_types=1);

namespace Application\Routers;

use Application\Controllers\CountryController;

class CountryRouter implements Router
{
    private array $routes = [];

    public function resolve(string $path, string $method)
    {
        $secondPath = explode('/', $path)[2];
        try {
            if (isset($this->routes[$method][$secondPath])) {
                return CountryController::{$this->routes[$method][$secondPath]}(
                );
            }
            throw new \Exception();
        } catch (\Exception $e) {
            return ['code' => 404, 'message' => 'Route not found'];
        }
    }

    public function addRoute(
        string $method,
        string $path,
        string $controllerMethod
    ) {
        $this->routes[$method][$path] = $controllerMethod;
    }
}