<?php

declare(strict_types=1);

namespace Henrik\Route\Utils;

use Hk\Contracts\HandlerTypesEnum;

class RouteOptions
{
    /**
     * @param string|array<string> $method
     * @param string|callable      $handler
     * @param array<string>        $middlewares
     * @param HandlerTypesEnum     $handlerType
     */
    public function __construct(
        private array|string $method,
        private $handler,
        private array $middlewares,
        private HandlerTypesEnum $handlerType
    ) {}

    /**
     * @return array<string>|string
     */
    public function getMethod(): array|string
    {
        return $this->method;
    }

    /**
     * @param array<string>|string $method
     *
     * @return void
     */
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

    /**
     * @return array<string>
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param array<string> $middlewares
     *
     * @return void
     */
    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public function getHandlerType(): HandlerTypesEnum
    {
        return $this->handlerType;
    }

    public function setHandlerType(HandlerTypesEnum $handlerType): void
    {
        $this->handlerType = $handlerType;
    }
}