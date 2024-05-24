<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/8  3:54:42.
 */
declare(strict_types=1);

namespace Henrik\Route\Utils;

use Henrik\Contracts\HandlerTypesEnum;
use Henrik\Route\Interfaces\RouteGraphBuilderInterface;
use Henrik\Route\RouteConstraints;

/**
 * Class RouteGraphBuilder.
 */
class RouteGraphBuilder implements RouteGraphBuilderInterface
{
    /**
     * @var array<string, mixed> $data
     */
    private array $data = [];

    /**
     * RouteDataGenerator constructor.
     *
     * @param string                $route
     * @param RouteOptions          $options
     * @param RouteConstraints|null $constraints
     */
    public function __construct(
        private readonly string $route,
        private readonly RouteOptions $options,
        private ?RouteConstraints $constraints = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        if ($this->route !== '/') {
            $routePartsArray = explode('/', ltrim($this->route, '/'));
            $this->data      = $this->segmentsBuilder($routePartsArray);

            return $this->data;
        }

        $this->data['/'][RouteGraphBuilderInterface::ROUTE_OPTIONS_KEY] = $this->buildOptionsData(); // @phpstan-ignore-line

        return $this->data;
    }

    /**
     * @param RouteConstraints $constraints
     */
    public function setConstraints(RouteConstraints $constraints): void
    {
        $this->constraints = $constraints;
    }

    /**
     * @param array<string>                      $routeSegmentsArray
     * @param array<string, string|RouteOptions> $graph
     *
     * @return array<string, array<int|string, RouteOptions>|string>|array<string, RouteOptions>|array<string, array<mixed>>
     */
    private function segmentsBuilder(array $routeSegmentsArray, array $graph = []): array
    {
        if (!empty($routeSegmentsArray)) {
            $indexData = array_shift($routeSegmentsArray);
            $graphNode = '/' . $indexData;

            if (preg_match('#{(?<param>[\w]+)}#', $indexData, $matches)) {
                $graphNode = '/' . $this->getConstraints($matches['param']);
            }

            $graph[$graphNode] = $this->segmentsBuilder($routeSegmentsArray, $graph);

            return $graph;
        }

        $graph[RouteGraphBuilderInterface::ROUTE_OPTIONS_KEY] = $this->buildOptionsData();

        return $graph;
    }

    /**
     * @param string $param
     *
     * @return string
     */
    private function getConstraints(string $param): string
    {
        if (!is_null($this->constraints) && isset($this->constraints->getSegments()[$param])) {
            return $this->constraints->getSegments()[$param];
        }

        return sprintf(RouteConstraints::SEGMENT_PATTERN, $param, RouteConstraints::ANY_PATTERN);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function buildOptionsData(): array
    {
        $handler = $this->options->getHandler();

        $method = $this->options->getMethod();

        if (is_string($handler)) {

            return [
                $handler => [
                    'method'      => $method,
                    'type'        => HandlerTypesEnum::METHOD,
                    'middlewares' => $this->options->getMiddlewares(),
                ],
            ];
        }

        return [
            'function' . md5(is_array($method) ? implode(',', $method) : $method) => [
                'type'            => HandlerTypesEnum::FUNCTION,
                'method'          => $method,
                'middlewares'     => $this->options->getMiddlewares(),
                'handlerFunction' => $handler,
            ],
        ];

    }
}