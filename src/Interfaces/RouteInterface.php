<?php

declare(strict_types=1);

namespace Henrik\Route\Interfaces;

use Henrik\Route\Utils\RouteOptions;

interface RouteInterface
{
    public function getRouteOptions(): RouteOptions;

    public function setRouteOptions(RouteOptions $routeOptions): void;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array;

    /**
     * @param string $param
     * @param mixed  $value
     */
    public function addParam(string $param, mixed $value): void;

    /**
     * @param array<string, mixed> $params
     *
     * @return void
     */
    public function setParams(array $params): void;
}