<?php

declare(strict_types=1);

namespace henrik\route\Utils;

use henrik\route\RouteGraph;

class RouteGraphItemBuilder
{
    private ?string $groupName = null;

    public function __construct(private readonly RouteGraph $routeGraph) {}

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function get(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $this->routeGraph->add(['GET'], $path, $handler, $constraints, $middlewars, $this->getGroupName());
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function post(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $this->routeGraph->add(['POST'], $path, $handler, $constraints, $middlewars, $this->getGroupName());
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function put(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $this->routeGraph->add(['PUT'], $path, $handler, $constraints, $middlewars, $this->getGroupName());
    }

    /**
     * @param string          $path
     * @param callable|string $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function delete(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $this->routeGraph->add(['DELETE'], $path, $handler, $constraints, $middlewars, $this->getGroupName());
    }

    /**
     * @param string          $path
     * @param callable|string $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function patch(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $this->routeGraph->add(['PATCH'], $path, $handler, $constraints, $middlewars, $this->getGroupName());
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function head(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $this->routeGraph->add(['HEAD'], $path, $handler, $constraints, $middlewars, $this->getGroupName());
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function any(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $this->routeGraph->add(['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'PATCH'], $path, $handler, $constraints, $middlewars, $this->getGroupName());
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(?string $groupName): void
    {
        $this->groupName = $groupName;
    }
}