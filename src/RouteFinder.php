<?php

declare(strict_types=1);

namespace henrik\route;

use henrik\route\Interfaces\RouteFinderInterface;
use henrik\route\Interfaces\RouteInterface;

readonly class RouteFinder implements RouteFinderInterface
{
    public function __construct(private RouteGraph $routeGraph) {}

    /**
     * @param array<string> $uriSegments
     *
     * @return RouteInterface|null
     */
    public function find(array $uriSegments): ?RouteInterface
    {
        return $this->routeFinder($this->routeGraph->getRoutes(), $uriSegments);
    }

    /**
     * @param mixed                 $routes
     * @param array<string>         $uriSegments
     * @param array<string, string> $routeParams
     *
     * @return ?RouteInterface
     */
    private function routeFinder(mixed $routes, array $uriSegments, array $routeParams = []): ?RouteInterface
    {
        if (is_array($routes)) {
            if (isset($uriSegments[0], $routes[$uriSegments[0]])) {
                $routes = $routes[$uriSegments[0]];
                array_shift($uriSegments);

                return $this->routeFinder($routes, $uriSegments, $routeParams);
            }

            if (isset($uriSegments[0])) {

                $matches = $this->parseSegments($routes, $uriSegments, $routeParams);

                if (empty($matches)) {
                    return null;
                }
            }

            if (!empty($uriSegments)) {
                return $this->routeFinder($routes, $uriSegments, $routeParams);
            }

            $route = new RouteData();
            $route->setRouteOptions($routes[RouteGraphBuilder::ROUTE_OPTIONS_KEY]);
            $route->setParams($routeParams);

            return $route;
        }

        return null;
    }

    /**
     * @param array<mixed>          $routes
     * @param array<string>         $uriSegments
     * @param array<string, string> $routeParams
     *
     * @return array<string, string>
     */
    private function parseSegments(array &$routes, array &$uriSegments, ?array &$routeParams): array
    {
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

        return $matches;
    }
}