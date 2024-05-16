<?php

namespace henrik\route\RouteBuilderConstraints;

use henrik\route\Interfaces\RouteBuilderConstraintInterface;

abstract class RouteBuilderConstraint implements RouteBuilderConstraintInterface
{
    public function __construct(protected null|bool|float|int|string $value) {}
}