<?php

namespace Henrik\Route\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Post extends Route
{
    public function __construct(string $path = '', ?array $constraints = null, ?array $middlewares = null, ?string $name = null)
    {
        parent::__construct($path, ['POST'], $constraints, $middlewares, $name);
    }
}