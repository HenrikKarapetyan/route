<?php

namespace Henrik\Route\RouteBuilderConstraints;

use Henrik\Route\Interfaces\RouteBuilderConstraintInterface;

abstract class RouteBuilderConstraint implements RouteBuilderConstraintInterface
{
    public function __construct(protected null|bool|float|int|string $value) {}
}