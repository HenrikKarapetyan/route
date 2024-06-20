<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 10:39 AM.
 */
declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Contracts\HandlerTypesEnum;
use Henrik\Route\Exceptions\NamedRouteException;
use Henrik\Route\Interfaces\RouteGraphInterface;
use Henrik\Route\Utils\RouteGraphBuilder;
use Henrik\Route\Utils\RouteOptions;

/**
 * Class RouteCollector.
 */
class RouteGraph implements RouteGraphInterface
{
    /**
     * @var array<int|string, array<int|string, mixed>|string>|array<mixed>
     */
    private array $routes = [];

    /** @var array<string, string> */
    private array $namedRoutesMap = [];

    public function getRouteByName(string $name, ?string $default = null): ?string
    {
        return $this->namedRoutesMap[$name] ?? $default;
    }

    /**
     * {@inheritdoc}
     *
     * @param array               $methods
     * @param string              $path
     * @param callable|string     $handler
     * @param array|callable|null $constraints
     * @param array               $middlewares
     * @param string|null         $groupName
     * @param string|null         $name
     */
    public function add(
        array $methods,
        string $path,
        callable|string $handler,
        null|array|callable $constraints = null,
        array $middlewares = [],
        ?string $groupName = null,
        ?string $name = null
    ): void {
        $route = $path;

        if ($groupName) {
            $route = sprintf('/%s/%s', trim($groupName, '/'), ltrim($route, '/'));
        }

        if ($name) {
            $this->addNamedRoute($name, $route);
        }

        $constraint = null;

        if (!is_null($constraints) && is_callable($constraints)) {
            $constraint = new RouteConstraints();
            $constraints($constraint);
        }

        if (is_array($constraints)) {
            $constraint = (new RouteConstraints())->buildFromArray($constraints);
        }

        $options = new RouteOptions(
            $methods,
            $handler,
            $middlewares,
            is_callable($handler) ? HandlerTypesEnum::FUNCTION : HandlerTypesEnum::METHOD
        );

        $routeGraphBuilder = new RouteGraphBuilder($route, $options, $constraint);
        $routeParsedData   = $routeGraphBuilder->build();

        if (!empty($this->routes)) {
            $this->routes = array_merge_recursive($routeParsedData, $this->routes);

            return;
        }

        $this->routes = $routeParsedData;

    }

    /**
     * @return array<int|string, array<int|string, mixed>|string>|array<mixed>
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function addNamedRoute(string $name, string $path): void
    {
        if (isset($this->namedRoutesMap[$name])) {
            throw new NamedRouteException($name, $path, $this->namedRoutesMap[$name]);
        }

        $this->namedRoutesMap[$name] = $path;

    }
}