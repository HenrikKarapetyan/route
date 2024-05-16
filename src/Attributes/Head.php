<?php

namespace henrik\route\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Head extends Route
{
    public function __construct(string $path, ?array $constraints = null, ?array $middlewares = null)
    {
        parent::__construct($path, ['HEAD'], $constraints, $middlewares);
    }
}