<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/14/2018
 * Time: 3:05 PM.
 */
declare(strict_types=1);

namespace henrik\route\Interfaces;

/**
 * Interface RouteCollectorInterface.
 */
interface RouteCollectorInterface
{
    /**
     * @param array<string>   $methods
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function add(
        array $methods,
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function get(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function post(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function put(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function delete(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function patch(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        $middlewars = []
    ): void;

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function head(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     *
     * @return void
     */
    public function any(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;
}