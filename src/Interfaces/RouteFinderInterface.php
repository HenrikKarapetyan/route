<?php

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