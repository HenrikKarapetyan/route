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
     * @param string          $path
     * @param string|callable $handler
     * @param callable|null   $constraints
     * @param array<string>   $middlewars
     *
     * @return void
     */
    abstract public function add(
        array $methods,
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void;

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
        $this->add(['GET'], $path, $handler, $constraints, $middlewars);
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
        $this->add(['POST'], $path, $handler, $constraints, $middlewars);
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
        $this->add(['PUT'], $path, $handler, $constraints, $middlewars);
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
        $this->add(['DELETE'], $path, $handler, $constraints, $middlewars);
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
        $this->add(['PATCH'], $path, $handler, $constraints, $middlewars);
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
        $this->add(['HEAD'], $path, $handler, $constraints, $middlewars);
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
        $this->add(['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'PATCH'], $path, $handler, $constraints, $middlewars);
    }
}