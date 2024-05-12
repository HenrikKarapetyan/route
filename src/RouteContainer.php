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
class RouteContainer
{
    /**
     * @param callable $callback
     */
    public static function routes(callable $callback): void
    {
        $rc = new RouteCollector();
        $callback($rc);
    }

    /**
     * @param string   $group
     * @param callable $callback
     */
    public static function group(string $group, callable $callback): void
    {
        $rc = new RouteCollector();
        $rc->setGroupName($group);
        $callback($rc);
    }

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public static function get(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteCollector();
        $rc->get($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public static function post(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteCollector();
        $rc->post($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public static function put(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteCollector();
        $rc->put($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public static function head(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteCollector();
        $rc->head($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public static function patch(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $rc = new RouteCollector();
        $rc->patch($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public static function delete(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteCollector();
        $rc->delete($route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public static function any(string $route, callable|string $handler, ?callable $callback = null, array $middlewars = []): void
    {
        $rc = new RouteCollector();
        $rc->any($route, $handler, $callback, $middlewars);
    }
}