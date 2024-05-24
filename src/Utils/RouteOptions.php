<?php

declare(strict_types=1);

namespace Henrik\Route\Utils;

use Henrik\Contracts\HandlerTypesEnum;
use Henrik\Contracts\Route\RouteOptionInterface;

class RouteOptions implements RouteOptionInterface
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
     * @return self
     */
    public function setMethod(array|string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getHandler(): callable|string
    {
        return $this->handler;
    }

    public function setHandler(callable|string $handler): self
    {
        $this->handler = $handler;

        return $this;
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
     * @return self
     */
    public function setMiddlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    public function getHandlerType(): HandlerTypesEnum
    {
        return $this->handlerType;
    }

    public function setHandlerType(HandlerTypesEnum $handlerType): self
    {
        $this->handlerType = $handlerType;

        return $this;
    }
}