<?php

declare(strict_types=1);

namespace henrik\route;

use henrik\route\Exceptions\UrlNotFoundException;
use henrik\route\Interfaces\RouteFinderInterface;
use henrik\route\Interfaces\RouteInterface;

/**
 * Class RouteDispatcher.
 */
readonly class RouteDispatcher
{
    public function __construct(private RouteFinderInterface $routeFinder) {}

    /**
     * @param string|null               $uri
     * @param array<string, int|string> $queryParams
     *
     * @return RouteInterface
     */
    public function dispatch(?string $uri = null, array $queryParams = []): RouteInterface
    {
        $fullUri       = !is_null($uri) ? $this->urlQueryParamsToUrlSegment($uri, $queryParams) : null;
        $uriSegments[] = '/';

        if ($fullUri !== '/') {
            $uriSegments = explode('/', ltrim((string) $fullUri, '/'));
            array_walk($uriSegments, function (&$value) {
                $value = '/' . $value;
            });
        }

        $res = $this->routeFinder->find($uriSegments);

        if (!$res instanceof RouteInterface) {
            throw new UrlNotFoundException((string) $fullUri);
        }

        return $res;
    }

    /**
     * @param string                    $uri
     * @param array<string, int|string> $queryParams
     *
     * @return string
     */
    public function urlQueryParamsToUrlSegment(string $uri, array $queryParams = []): string
    {
        if (!empty($queryParams)) {
            $values                  = array_values($queryParams);
            $uriQueryParamsAsUrlPart = implode('/', $values);

            if ($uri[-1] === '/') {
                return $uri . $uriQueryParamsAsUrlPart . '/';
            }

            return $uri . '/' . $uriQueryParamsAsUrlPart;
        }

        return $uri;
    }
}