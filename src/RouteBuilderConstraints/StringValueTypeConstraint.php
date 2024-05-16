<?php

namespace henrik\route\RouteBuilderConstraints;

class StringValueTypeConstraint extends RouteBuilderConstraint
{
    public function execute(): string
    {
        return (string) $this->value;
    }
}