<?php

namespace Henrik\Route\RouteBuilderConstraints;

class StringValueTypeConstraint extends RouteBuilderConstraint
{
    public function execute(): string
    {
        return (string) $this->value;
    }
}