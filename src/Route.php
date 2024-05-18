<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/8  4:12:35.
 */
declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Route\Utils\RouteGraphItemBuilder;

/**
 * Class RouteContainer.
 */
class Route
{
    public function __construct(private RouteGraph $routeGraph) {}

    /**
     * @param callable $constraints
     */
    public function routes(callable $constraints): void
    {
        $constraints(new RouteGraphItemBuilder($this->routeGraph));
    }

    /**
     * @param string   $group
     * @param callable $constraints
     */
    public function group(string $group, callable $constraints): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->setGroupName($group);
        $constraints($rc);
    }

    /**
     * @param string          $path
     * @param callable|string $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function get(string $path, callable|string $handler, ?callable $constraints = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->get($path, $handler, $constraints, $middlewars);
    }

    /**
     * @param string          $path
     * @param callable|string $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function post(string $path, callable|string $handler, ?callable $constraints = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->post($path, $handler, $constraints, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function put(string $path, callable|string $handler, ?callable $constraints = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->put($path, $handler, $constraints, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function head(string $path, callable|string $handler, ?callable $constraints = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->head($path, $handler, $constraints, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function patch(
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->patch($path, $handler, $constraints, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function delete(string $path, callable|string $handler, ?callable $constraints = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->delete($path, $handler, $constraints, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     */
    public function any(string $path, callable|string $handler, ?callable $constraints = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->any($path, $handler, $constraints, $middlewars);
    }
}