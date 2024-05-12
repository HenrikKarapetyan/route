<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/6/2018
 * Time: 10:39 AM.
 */
declare(strict_types=1);

namespace henrik\route;

/**
 * Class RouteCollector.
 */
class RouteGraph extends AbstractRouteGraph
{
    /**
     * @var array<mixed>
     */
    private static array $routes = [];
    /**
     * @var ?string
     */
    private ?string $groupName = null;

    /**
     * {@inheritdoc}
     */
    public function add(
        array $methods,
        string $path,
        callable|string $handler,
        ?callable $constraints = null,
        array $middlewars = []
    ): void {
        $route      = $this->groupName . $path;
        $constraint = null;

        if (!is_null($constraints) && is_callable($constraints)) {
            $constraint = new RouteConstraints();
            $constraints($constraint);
        }

        $options           = new RouteOptions($methods, $handler, $middlewars);
        $routeGraphBuilder = new RouteGraphBuilder($route, $options, $constraint);
        $routeParsedData   = $routeGraphBuilder->build();

        if (!empty(self::$routes)) {
            self::$routes = array_merge_recursive($routeParsedData, self::$routes);

            return;
        }

        self::$routes = $routeParsedData;

    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return !is_null($this->groupName) ? $this->groupName : '';
    }

    /**
     * @param string $groupName
     *
     * @return RouteGraph
     */
    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getRoutes(): array
    {
        return self::$routes;
    }
}