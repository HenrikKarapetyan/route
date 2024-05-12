<?php

namespace henrik\route\RouteConstraints;

interface RouteConstraintInterface
{
    public function execute(): string;
}