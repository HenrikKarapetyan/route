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
class RouteCollector extends AbstractRouteCollector
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
        string $route,
        callable|string $handler,
        ?callable $callback = null,
        array $middlewars = []
    ): void {
        $route       = $this->groupName . $route;
        $constraints = null;

        if (!is_null($callback) && is_callable($callback)) {
            $constraints = new RouteConstraints();
            $callback($constraints);
        }

        $options = [
            'method'     => $methods,
            'handler'    => $handler,
            'middlewars' => $middlewars,
        ];

        $rp              = new RouteParser($route, $options, $constraints);
        $routeParsedData = $rp->parse();

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
     * @return RouteCollector
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