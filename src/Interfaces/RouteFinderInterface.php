<?php

declare(strict_types=1);

namespace henrik\route\Interfaces;

interface RouteFinderInterface
{
    /**
     * @param array<int|string, string|array<int|string, mixed>> $uriSegments
     *
     * @return RouteInterface|null
     */
    public function find(array $uriSegments): ?RouteInterface;
}