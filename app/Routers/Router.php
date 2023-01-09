<?php

declare(strict_types=1);

namespace Application\Routers;

interface Router
{
    public function resolve(string $path, string $method);

    public function addRoute(
        string $method,
        string $path,
        string $controllerMethod
    );
}