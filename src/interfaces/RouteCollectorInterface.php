<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/14/2018
 * Time: 3:05 PM
 */

namespace henrik\route\interfaces;


/**
 * Interface RouteCollectorInterface
 * @package henrik\route
 */
interface RouteCollectorInterface
{

    /**
     * @param $methods
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function add($methods, $route, $handler, callable $callback = null, $middlewars = []);

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function get($route, $handler, callable $callback = null, $middlewars = []);

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function post($route, $handler, callable $callback = null, $middlewars = []);

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function put($route, $handler, callable $callback = null, $middlewars = []);

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function delete($route, $handler, callable $callback = null, $middlewars = []);

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function patch($route, $handler, callable $callback = null, $middlewars = []);

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function head($route, $handler, callable $callback = null, $middlewars = []);

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public function any($route, $handler, callable $callback = null, $middlewars = []);
}