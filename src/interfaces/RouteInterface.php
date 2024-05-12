<?php

namespace henrik\route\interfaces;

interface RouteInterface
{
    /**
     * @param array<string> $middlewars
     */
    public function setMiddlewars(array $middlewars): void;

    /**
     * @return string|array<string>
     */
    public function getHttpMethod(): array|string;

    /**
     * @param string|array<string> $httpMethod
     */
    public function setHttpMethod(array|string $httpMethod): void;

    /**
     * @return string|callable
     */
    public function getHandler(): callable|string;

    /**
     * @param string|callable $handler
     */
    public function setHandler(callable|string $handler): void;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array;

    /**
     * @param string $param
     * @param mixed  $value
     */
    public function setParam(string $param, mixed $value): void;
}