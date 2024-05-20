<?php

namespace Henrik\Route\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Patch extends Route
{
    public function __construct(string $path = '', ?array $constraints = null, ?array $middlewares = null)
    {
        parent::__construct($path, ['PATCH'], $constraints, $middlewares);
    }
}