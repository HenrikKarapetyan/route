<?php

namespace henrik\route\RouteConstraints;

class StringValueTypeConstraint extends RouteConstraint
{
    public function execute(): string
    {
        return (string) $this->value;
    }
}