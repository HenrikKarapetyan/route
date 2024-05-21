<?php

declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Route\Interfaces\RouteGraphBuilderInterface;
use Henrik\Route\Interfaces\RouteGraphInterface;
use Henrik\Route\Interfaces\RouteMatcherInterface;
use Henrik\Route\Utils\RouteOptions;
use Hk\Contracts\HandlerTypesEnum;
use Hk\Contracts\Route\RouteInterface;

class RouteMatcher implements RouteMatcherInterface
{
    private string $requestMethod = 'GET';

    public function __construct(private readonly RouteGraphInterface $routeGraph) {}

    /**
     * @param array<string> $uriSegments
     * @param string        $requestMethod
     *
     * @return RouteInterface|null
     */
    public function match(array $uriSegments, string $requestMethod): ?RouteInterface
    {
        $this->setRequestMethod($requestMethod);

        return $this->routeMatcher($this->routeGraph->getRoutes(), $uriSegments);
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function setRequestMethod(string $requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @param mixed                 $routes
     * @param array<string>         $uriSegments
     * @param array<string, string> $routeParams
     *
     * @return ?RouteInterface
     */
    private function routeMatcher(mixed $routes, array $uriSegments, array $routeParams = []): ?RouteInterface
    {
        if (is_array($routes)) {
            if (isset($uriSegments[0], $routes[$uriSegments[0]])) {
                $routes = $routes[$uriSegments[0]];
                array_shift($uriSegments);

                return $this->routeMatcher($routes, $uriSegments, $routeParams);
            }

            if (isset($uriSegments[0])) {

                $matches = $this->parseSegments($routes, $uriSegments, $routeParams);

                if (empty($matches)) {
                    return null;
                }
            }

            if (!empty($uriSegments)) {
                return $this->routeMatcher($routes, $uriSegments, $routeParams);
            }

            return $this->getRouteResponse($routes[RouteGraphBuilderInterface::ROUTE_OPTIONS_KEY], $routeParams);
        }

        return null;
    }

    /**
     * @param array<string, array<string, array<string, array<string>>>> $routes
     * @param array<string, string>                                      $routeParams
     *
     * @return RouteInterface|null
     */
    private function getRouteResponse(array $routes, array $routeParams): ?RouteInterface
    {
        foreach ($routes as $handler => $options) {

            if (!in_array($this->getRequestMethod(), $options['method'])) {
                continue;
            }

            $routeData = new RouteData();
            $routeData->setParams($routeParams);

            $handlerType = HandlerTypesEnum::METHOD;

            /**
             * @var HandlerTypesEnum $type
             */
            $type = $options['type'];

            /** @var array<string> $middlewares */
            $middlewares = $options['middlewares'];

            if ($type == HandlerTypesEnum::FUNCTION) {
                $handlerType = HandlerTypesEnum::FUNCTION;
                /** @var callable $handler */
                $handler = $options['handlerFunction'];
            }

            $routeData->setRouteOptions(
                new RouteOptions(
                    $this->getRequestMethod(),
                    $handler,
                    $middlewares,
                    $handlerType
                )
            );

            return $routeData;

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