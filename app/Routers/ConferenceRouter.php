<?php

declare(strict_types=1);

namespace Application\Routers;

use Application\Controllers\ConferenceController;

class ConferenceRouter implements Router
{
    private array $routes = [];

    public function resolve(
        string $path,
        string $method,
        array $conferenceData = []
    ): array {
        $secondPath = explode('/', $path)[2];
        try {
            if (isset($this->routes[$method][$secondPath])) {
                return ConferenceController::{$this->routes[$method][$secondPath]}(
                    $conferenceData
                );
            } elseif (isset($this->routes[$method][':id'])) {
                return ConferenceController::{$this->routes[$method][':id']}(
                    $secondPath,
                    $conferenceData
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