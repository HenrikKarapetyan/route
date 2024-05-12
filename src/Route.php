<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 1/25/2018
 * Time: 10:47 AM.
 */
declare(strict_types=1);

namespace henrik\route;

use henrik\route\interfaces\RouteInterface;

/**
 * Class Route.
 */
class Route implements RouteInterface
{
    /**
     * @var string|array<string>
     */
    private array|string $httpMethod;

    /** @var array<string, mixed> */
    private array $params = [];

    /**
     * @var string|callable $handler
     */
    private $handler;

    /**
     * @var array<string>
     */
    private array $middlewars = [];

    /**
     * @return array<string>
     */
    public function getMiddlewars()
    {
        return $this->middlewars;
    }

    /**
     * @param array<string> $middlewars
     */
    public function setMiddlewars(array $middlewars): void
    {
        $this->middlewars = $middlewars;
    }

    /**
     * @return string|array<string>
     */
    public function getHttpMethod(): array|string
    {
        return $this->httpMethod;
    }

    /**
     * @param string|array<string> $httpMethod
     */
    public function setHttpMethod(array|string $httpMethod): void
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * @return string|callable
     */
    public function getHandler(): callable|string
    {
        return $this->handler;
    }

    /**
     * @param string|callable $handler
     */
    public function setHandler(callable|string $handler): void
    {
        $this->handler = $handler;
    }

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
    public function setParam(string $param, mixed $value): void
    {
        $this->params[$param] = $value;
    }
}