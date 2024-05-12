<?php

declare(strict_types=1);

namespace henrik\route\Interfaces;

interface RouteGraphInterface
{
    /**
     * @param array<string>   $methods
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     * @param string|null     $groupName
     *
     * @return void
     */
    public function add(
        array $methods,
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = [],
        ?string $groupName = null
    ): void;
}