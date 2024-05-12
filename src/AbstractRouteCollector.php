<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 2:03 PM.
 */
declare(strict_types=1);

namespace henrik\route;

/**
 * Class AbstractRouteCollector.
 */
abstract class AbstractRouteCollector
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
    abstract public function add(
        array $methods,
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void;

    // ** REQUEST METHODS *//

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function get(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $this->add(['GET'], $route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function post(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $this->add(['POST'], $route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function put(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $this->add(['PUT'], $route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function delete(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $this->add(['DELETE'], $route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param callable|string $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function patch(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $this->add(['PATCH'], $route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function head(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $this->add(['HEAD'], $route, $handler, $callback, $middlewars);
    }

    /**
     * @param string          $route
     * @param string|callable $handler
     * @param callable|null   $callback
     * @param array<string>   $middlewars
     */
    public function any(
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $this->add(['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'PATCH'], $route, $handler, $callback, $middlewars);
    }
}