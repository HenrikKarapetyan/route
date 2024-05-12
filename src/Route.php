<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/8  4:12:35.
 */
declare(strict_types=1);

namespace henrik\route;

/**
 * Class RouteContainer.
 */
class Route
{
    public function __construct(private RouteGraph $routeGraph) {}

    /**
     * @param callable $callback
     */
    public function routes(callable $callback): void
    {
        $callback(new RouteGraphItemBuilder($this->routeGraph));
    }

    /**
     * @param string   $group
     * @param callable $callback
     */
    public function group(string $group, callable $callback): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->setGroupName($group);
        $callback($rc);
    }

    /**
     * @param string          $path
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function get(string $path, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->get($path, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $path
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function post(string $path, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->post($path, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function put(string $path, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->put($path, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function head(string $path, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->head($path, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function patch(
        string $path,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->patch($path, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function delete(string $path, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->delete($path, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function any(string $path, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraphItemBuilder($this->routeGraph);
        $rc->any($path, $handler, $callback, $middlewars);
    }
}