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
 * Class RouteParser.
 */
class RouteParser
{
    /**
     * @var array<string, mixed> $data
     */
    private array $data = [];

    /**
     * RouteDataGenerator constructor.
     *
     * @param string                $route
     * @param array<string, mixed>  $options
     * @param RouteConstraints|null $constraints
     */
    public function __construct(
        private readonly string $route,
        private readonly array $options,
        private ?RouteConstraints $constraints = null
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function parse(): array
    {
        if ($this->route !== '/') {
            $routePartsArray = explode('/', ltrim($this->route, '/'));
            $this->data      = $this->parser($routePartsArray);

            return $this->data;
        }

        $this->data['/']['options'] = $this->options; // @phpstan-ignore-line

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
     * @param array<string>         $routeSegmentsArray
     * @param array<string, string> $helper
     *
     * @return array<string, array<mixed>|string>
     */
    private function parser(array $routeSegmentsArray, array $helper = []): array
    {
        if (!empty($routeSegmentsArray)) {
            $indexData = array_shift($routeSegmentsArray);
            $part      = '/' . $indexData;

            if (preg_match('#{(?<param>[\w]+)}#', $indexData, $matches)) {
                $part = '/' . $this->getConstraints($matches['param']);
            }

            $helper[$part] = $this->parser($routeSegmentsArray, $helper);

            return $helper;
        }

        $helper['options'] = $this->options;

        return $helper;
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