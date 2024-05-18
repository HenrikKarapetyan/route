<?php

declare(strict_types=1);

namespace Henrik\Route\Interfaces;

interface RouteFinderInterface
{
    /**
     * @param array<int|string, string|array<int|string, mixed>> $uriSegments
     *
     * @return RouteInterface|null
     */
    public function find(array $uriSegments): ?RouteInterface;
}