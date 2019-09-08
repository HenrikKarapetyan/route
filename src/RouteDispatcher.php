<?php

namespace henrik\route;

use henrik\route\exceptions\RouteConfigurationException;
use henrik\route\exceptions\UrlNotFoundException;

/**
 * Class RouteDispatcher
 * @package henrik\route
 */
class RouteDispatcher
{
    /**
     * @var Route
     */
    private $route;

    /**
     * @var RouteCollector
     */
    private $routeCollector;

    /**
     * RouteDispatcher constructor.
     * @param RouteCollector $routeCollector
     */
    public function __construct(RouteCollector $routeCollector)
    {
        $this->routeCollector = $routeCollector;
    }

    /**
     * @param null $uri
     * @param array $query_params
     * @return array
     */
    public function dispatch($uri = null, $query_params = [])
    {
        $this->route = new Route();
        $uri = $this->url_query_params_to_url_segment($uri, $query_params);
        if ($uri === '/') {
            $data[] = '/';
        } else {
            $data = explode('/', ltrim($uri, '/'));
            array_walk($data, function (&$value) {
                $value = "/" . $value;
            });
        }

        $routes = $this->routeCollector->getRoutes();
        $res = $this->routeFinder($routes, $data);
        if ($res) {
            /**
             * @handler Closure|array
             */
            $handler = $this->route->getHandler();
            if (is_callable($handler) && $handler instanceof \Closure) {

                return [
                    'invoker' => 'function',
                    'handler' => $handler,
                    'middlewars' => $this->route->getMiddlewars(),
                    'params' => $this->route->getParams()
                ];
            } elseif (is_array($handler)) {
                isset($handler[0]) ? $controller_id = $handler[0] : $controller_id = 'home';
                isset($handler[1]) ? $action = $handler[1] : $action = 'index';
                return [
                    'invoker' => 'method',
                    'handler' => [
                        'controller' => $controller_id,
                        'action' => $action
                    ],
                    'middlewars' => $this->route->getMiddlewars(),
                    'params' => $this->route->getParams()

                ];

//                try {
//                    $controller_inst = $this->controllersContainer->get($controller_id);
//                    return [
//                        'invoker' => 'method',
//                        'handler' => [
//                            'controller' => $controller_inst,
//                            'action' => $action
//                        ]
//                    ];
//                } catch (ServiceNotFoundException $e) {
//                    throw new ControllerNotFoundException(sprintf('the "%s" controller not found %s', $handler[0], $e->getMessage()));
//                } catch (MethodNotFoundException $e) {
//                    throw new ActionNotFoundException(sprintf('the "%s" action not found', $action));
//                }
            } else {
                throw new RouteConfigurationException(sprintf("Invalid  configuration for route handler"));
            }
        } else {
            throw new UrlNotFoundException(sprintf('the "%s" requested url not found', $uri));
        }
    }

    /**
     * @param $routes
     * @param $uri_segments
     * @return bool
     */
    public function routeFinder($routes, $uri_segments)
    {
        if (isset($uri_segments[0]) && isset($routes[$uri_segments[0]])) {
            $routes = $routes[$uri_segments[0]];
            array_shift($uri_segments);
            return $this->routeFinder($routes, $uri_segments);
        } else if (isset($uri_segments[0])) {
            $matches = [];
            foreach ($routes as $index => $routes_array) {
                if (isset($index[1]) && $index[1] === '(') {
                    $pattern = '#' . $index . '$#xis';
                    if (preg_match($pattern, $uri_segments[0], $matches)) {
                        $routes = $routes[$index];
                        foreach ($matches as $key => $value) {
                            if (is_string($key)) {
                                $this->route->setParam($key, $value);
                            }
                        }
                        array_shift($uri_segments);
                        break;
                    }

                }

            }
            if (empty($matches)) return false;
        }
        if (!empty($uri_segments)) {
            return $this->routeFinder($routes, $uri_segments);
        } else {
            if (!isset($routes['options'])) {
                return false;
            } else {
                $this->route->setHttpMethod($routes['options']['method']);
                $this->route->setHandler($routes['options']['handler']);
                $this->route->setMiddlewars($routes['options']['middlewars']);
            }
            return true;
        }
    }


    /**
     * @param $uri
     * @param array $query_params
     * @return string
     */
    public function url_query_params_to_url_segment($uri, $query_params = [])
    {
        if (!empty($query_params)) {
            $values = array_values($query_params);
            $uri_query_params_as_url_part = implode('/', $values);
            if ($uri[-1] === '/') {
                $uri .= $uri_query_params_as_url_part . '/';
            } else {
                $uri .= '/' . $uri_query_params_as_url_part;
            }
        }
        return $uri;
    }
}