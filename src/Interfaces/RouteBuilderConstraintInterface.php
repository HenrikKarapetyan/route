<?php

namespace henrik\route\Interfaces;

interface RouteBuilderConstraintInterface
{
    public function execute(): string;
}