<?php

namespace henrik\route;

use henrik\route\Interfaces\RouteInterface;

class RouteFinder extends RouteCollector
{
    /**
     * @param array<int|string, string|array<int|string, mixed>> $uriSegments
     *
     * @return RouteInterface|null
     */
    public function find(array $uriSegments): ?RouteInterface
    {
        return $this->routeFinder($this->getRoutes(), $uriSegments);
    }

    /**
     * @param array<array>          $routes
     * @param array<string>         $uriSegments
     * @param array<string, string> $routeParams
     *
     * @return ?RouteInterface
     */
    private function routeFinder(array $routes, array $uriSegments, array $routeParams = []): ?RouteInterface
    {
        if (isset($uriSegments[0], $routes[$uriSegments[0]])) {
            $routes = $routes[$uriSegments[0]];
            array_shift($uriSegments);

            return $this->routeFinder($routes, $uriSegments, $routeParams);
        }

        if (isset($uriSegments[0])) {

            $matches = [];
            foreach ($routes as $index => $routesArray) {

                if (isset($index[1]) && $index[1] === '(') {
                    $pattern = '#' . $index . '$#xis';

                    if (preg_match($pattern, $uriSegments[0], $matches)) {
                        $routes = $routesArray;

                        foreach ($matches as $key => $value) {
                            if (is_string($key)) {
                                $routeParams[$key] = $value;
                            }
                        }

                        array_shift($uriSegments);

                        break;
                    }

                }

            }

            if (empty($matches)) {
                return null;
            }
        }

        if (!empty($uriSegments)) {
            return $this->routeFinder($routes, $uriSegments, $routeParams);
        }

        $route = new Route();
        $route->setRouteOptions($routes[RouteGraphBuilder::ROUTE_OPTIONS_KEY]);
        $route->setParams($routeParams);

        return $route;
    }
}