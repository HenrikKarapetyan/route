<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/14/2018
 * Time: 3:07 PM.
 */
declare(strict_types=1);

namespace Henrik\Route\Interfaces;

/**
 * Interface RouteDispatcherInterface.
 */
interface RouteDispatcherInterface
{
    /**
     * @param string|null               $uri
     * @param string                    $requestMethod
     * @param array<string, int|string> $queryParams
     *
     * @return RouteInterface
     */
    public function dispatch(?string $uri = null, string $requestMethod = 'Get', array $queryParams = []): RouteInterface;
}