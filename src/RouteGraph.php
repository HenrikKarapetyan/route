<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 10:39 AM.
 */
declare(strict_types=1);

namespace henrik\route;

use henrik\route\Interfaces\RouteGraphInterface;
use henrik\route\Utils\RouteGraphBuilder;
use henrik\route\Utils\RouteOptions;

/**
 * Class RouteCollector.
 */
class RouteGraph implements RouteGraphInterface
{
    /**
     * @var array<int|string, array<int|string, mixed>|string>|array<mixed>
     */
    private array $routes = [];

    /**
     * {@inheritdoc}
     */
    public function add(
        array $methods,
        string $path,
        callable|string $handler,
        null|array|callable $constraints = null,
        array $middlewars = [],
        ?string $groupName = null
    ): void {
        $route = $path;

        if ($groupName) {
            $route = $groupName . $path;
        }
        $constraint = null;

        if (!is_null($constraints) && is_callable($constraints)) {
            $constraint = new RouteConstraints();
            $constraints($constraint);
        }

        if (is_array($constraints)) {
            $constraint = (new RouteConstraints())->buildFromArray($constraints);
        }

        $options           = new RouteOptions($methods, $handler, $middlewars);
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
}