<?php

declare(strict_types=1);

namespace Henrik\Route\Attributes;

use Attribute;
use Henrik\Route\Utils\RouteParamType;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Route
{
    public string $path;

    /** @var array<string> */
    public array $methods;

    /**
     * Example.
     *
     * ['id' => ['type' => RouteParamType::TYPE_STRING, 'from' => 1, 'to' => 255]].
     *
     * @var array<string, array<string, string|int|RouteParamType|null>>
     */
    public array $constraints;

    /**
     * @var array<string>
     */
    public array $middlewares;

    public ?string $name;

    /**
     * @param string                                                        $path
     * @param array<string>                                                 $methods
     * @param ?array<string, array<string, string|int|RouteParamType|null>> $constraints
     * @param array<string>|null                                            $middlewares
     * @param string|null                                                   $name
     */
    public function __construct(
        string $path = '',
        ?array $methods = null,
        ?array $constraints = null,
        ?array $middlewares = null,
        ?string $name = null
    ) {
        $this->path        = $path;
        $this->methods     = $methods ?: ['GET'];
        $this->constraints = $constraints ?: [];
        $this->middlewares = $middlewares ?: [];
        $this->name        = $name;
    }
}