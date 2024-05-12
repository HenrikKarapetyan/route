<?php
/**
 * Copyright (c)  2016
 * Author  Henrik Karapetyan
 * Email:  henrikkarapetyan@gmail.com
 * Country: Armenia
 * File created:  2019/9/8  3:54:42.
 */
declare(strict_types=1);

namespace henrik\route;

/**
 * Class RouteGraphBuilder.
 */
class RouteGraphBuilder
{
    public const ROUTE_OPTIONS_KEY = 'options';
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

        $this->data['/'][self::ROUTE_OPTIONS_KEY] = $this->options; // @phpstan-ignore-line

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

        $graph[self::ROUTE_OPTIONS_KEY] = $this->options;

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
}