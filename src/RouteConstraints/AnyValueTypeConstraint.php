<?php

namespace henrik\route\RouteConstraints;

class AnyValueTypeConstraint extends RouteConstraint
{
    public function execute(): string
    {
        return (string) $this->value;
    }
}