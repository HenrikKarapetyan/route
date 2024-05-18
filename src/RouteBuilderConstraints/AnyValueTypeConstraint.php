<?php

namespace Henrik\Route\RouteBuilderConstraints;

class AnyValueTypeConstraint extends RouteBuilderConstraint
{
    public function execute(): string
    {
        return (string) $this->value;
    }
}