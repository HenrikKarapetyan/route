<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/8  4:12:35.
 *
 */

namespace henrik\route;


/**
 * Class RouteContainer
 * @package henrik\route
 */
class RouteContainer
{

    /**
     * @param callable $callback
     */
    public static function routes(callable $callback)
    {
        $rc = new RouteCollector();
        $callback($rc);
    }

    /**
     * @param $group
     * @param callable $callback
     */
    public static function group($group, callable $callback)
    {
        $rc = new RouteCollector();
        $rc->setGroupName($group);
        $callback($rc);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     */
    public static function get($route, $handler, callable $callback = null, $middlewars = [])
    {
        $rc = new RouteCollector();
        $rc->get($route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     */
    public static function post($route, $handler, callable $callback = null, $middlewars = [])
    {
        $rc = new RouteCollector();
        $rc->post($route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     */
    public static function put($route, $handler, callable $callback = null, $middlewars = [])
    {
        $rc = new RouteCollector();
        $rc->put($route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     */
    public static function head($route, $handler, callable $callback = null, $middlewars = [])
    {
        $rc = new RouteCollector();
        $rc->head($route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public static function patch($route, $handler, callable $callback = null, $middlewars = [])
    {
        $rc = new RouteCollector();
        $rc->patch($route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public static function delete($route, $handler, callable $callback = null, $middlewars = [])
    {
        $rc = new RouteCollector();
        $rc->delete($route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public static function any($route, $handler, callable $callback = null, $middlewars = [])
    {
        $rc = new RouteCollector();
        $rc->any($route, $handler, $callback, $middlewars);
    }
}