<?php

declare(strict_types=1);

namespace Henrik\Route\Interfaces;

use Henrik\Contracts\Route\RouteInterface;

interface RouteMatcherInterface
{
    /**
     * @param array<int|string, string|array<int|string, mixed>> $uriSegments
     * @param string                                             $requestMethod
     *
     * @return RouteInterface|null
     */
    public function match(array $uriSegments, string $requestMethod): ?RouteInterface;
}