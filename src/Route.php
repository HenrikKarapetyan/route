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
    /**
     * @param callable $callback
     */
    public function routes(callable $callback): void
    {
        $rc = new RouteGraph();
        $callback($rc);
    }

    /**
     * @param string   $group
     * @param callable $callback
     */
    public function group(string $group, callable $callback): void
    {
        $rc = new RouteGraph();
        $rc->setGroupName($group);
        $callback($rc);
    }

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function get(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraph();
        $rc->get($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function post(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraph();
        $rc->post($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function put(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraph();
        $rc->put($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function head(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraph();
        $rc->head($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function patch(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $rc = new RouteGraph();
        $rc->patch($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function delete(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraph();
        $rc->delete($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function any(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteGraph();
        $rc->any($route, $handler, $callback, $middlewars);
    }
}