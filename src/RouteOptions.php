<?php

namespace henrik\route;

class RouteOptions
{
    /**
     * @param string|array<string> $method
     * @param string|callable      $handler
     * @param array<string>        $middlewares
     */
    public function __construct(
        private array|string $method,
        private $handler,
        private array $middlewares
    ) {}

    public function getMethod(): array|string
    {
        return $this->method;
    }

    public function setMethod(array|string $method): void
    {
        $this->method = $method;
    }

    public function getHandler(): callable|string
    {
        return $this->handler;
    }

    public function setHandler(callable|string $handler): void
    {
        $this->handler = $handler;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }
}