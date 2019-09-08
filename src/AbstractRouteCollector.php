<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 2:03 PM
 */

namespace henrik\route;


/**
 * Class AbstractRouteCollector
 * @package henrik\route
 */
abstract class AbstractRouteCollector
{

    /**
     * @param $methods
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     * @return mixed
     */
    public abstract function add($methods, $route, $handler, callable $callback = null, $middlewars = []);

    //** REQUEST METHODS *//

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public function get($route, $handler, callable $callback = null, $middlewars = [])
    {
        $this->add("GET", $route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public function post($route, $handler, callable $callback = null, $middlewars = [])
    {
        $this->add("POST", $route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public function put($route, $handler, callable $callback = null, $middlewars = [])
    {
        $this->add('PUT', $route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public function delete($route, $handler, callable $callback = null, $middlewars = [])
    {
        $this->add('DELETE', $route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public function patch($route, $handler, callable $callback = null, $middlewars = [])
    {
        $this->add("PATCH", $route, $handler, $callback, $middlewars);
    }

    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public function head($route, $handler, callable $callback = null, $middlewars = [])
    {
        $this->add('HEAD', $route, $handler, $callback, $middlewars);
    }


    /**
     * @param $route
     * @param $handler
     * @param callable|null $callback
     * @param array $middlewars
     */
    public function any($route, $handler, callable $callback = null, $middlewars = [])
    {
        $this->add(["GET", "POST", "PUT", "DELETE", "HEAD", "PATCH"], $route, $handler, $callback, $middlewars);
    }

}