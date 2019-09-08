<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 10:39 AM
 */

namespace henrik\route;


/**
 * Class RouteCollector
 * @package henrik\route
 */
class RouteCollector extends AbstractRouteCollector
{
    /**
     * @var array
     */
    private static $routes = [];
    /**
     * @var string
     */
    private $group_name;

    /**
     * @param $methods
     * @param $route
     * @param $handler
     * @param callable|null $callback
     */
    public function add($methods, $route, $handler, callable $callback = null, $middlewars = [])
    {
        $route = $this->group_name . $route;
        $constraints = null;
        if (!is_null($callback) && is_callable($callback)) {
            $constraints = new RouteConstraints();
            $callback($constraints);
        }
        $options = [
            'method' => $methods,
            'handler' => $handler,
            'middlewars' => $middlewars
        ];
        $rp = new RouteParser($route, $options, $constraints);
        $route_parsed_data = $rp->parse();
        if (!empty(self::$routes)) {
            self::$routes = array_merge_recursive($route_parsed_data, self::$routes);
        } else {
            self::$routes = $route_parsed_data;
        }
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        if (is_null($this->group_name)) {
            $this->group_name = '';
        }
        return $this->group_name;
    }

    /**
     * @param string $group_name
     * @return RouteCollector
     */
    public function setGroupName($group_name)
    {
        $this->group_name = $group_name;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return self::$routes;
    }
}