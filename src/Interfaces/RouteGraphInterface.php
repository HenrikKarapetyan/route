<?php

declare(strict_types=1);

namespace Henrik\Route\Interfaces;

interface RouteGraphInterface
{
    /**
     * @param array<string>                                                            $methods
     * @param string                                                                   $path
     * @param string|callable                                                          $handler
     * @param callable|array<string, string|array<string, array<string, string>>>|null $constraints
     * @param array<string>                                                            $middlewars
     * @param string|null                                                              $groupName
     *
     * @return void
     */
    public function add(
        array $methods,
        string $path,
        callable|string $handler,
        null|array|callable $constraints = null,
        array $middlewars = [],
        ?string $groupName = null
    ): void;

    public function addNamedRoute(string $name, string $path): void;

    public function getRouteByName(string $name, ?string $default = null): ?string;

    /**
     * @return array<int|string, array<int|string, mixed>|string>|array<mixed>
     */
    public function getRoutes(): array;
}