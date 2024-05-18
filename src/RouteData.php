<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 1/25/2018
 * Time: 10:47 AM.
 */
declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Route\Interfaces\RouteInterface;
use Henrik\Route\Utils\RouteOptions;

/**
 * Class RouteData.
 */
class RouteData implements RouteInterface
{
    /** @var array<string, mixed> */
    private array $params = [];

    private RouteOptions $routeOptions;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $param
     * @param mixed  $value
     */
    public function addParam(string $param, mixed $value): void
    {
        $this->params[$param] = $value;
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getRouteOptions(): RouteOptions
    {
        return $this->routeOptions;
    }

    public function setRouteOptions(RouteOptions $routeOptions): void
    {
        $this->routeOptions = $routeOptions;
    }
}