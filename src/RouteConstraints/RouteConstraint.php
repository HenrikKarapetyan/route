<?php

namespace henrik\route\RouteConstraints;

abstract class RouteConstraint implements RouteConstraintInterface
{
    public function __construct(protected null|bool|float|int|string $value) {}
}