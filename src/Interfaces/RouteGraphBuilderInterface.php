<?php

namespace Henrik\Route\Interfaces;

use Henrik\Route\RouteConstraints;

interface RouteGraphBuilderInterface
{
    public const ROUTE_OPTIONS_KEY = 'options';

    /**
     * @return array<string, mixed>
     */
    public function build(): array;

    public function setConstraints(RouteConstraints $constraints): void;
}