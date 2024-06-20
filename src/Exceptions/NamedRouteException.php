<?php

namespace Henrik\Route\Exceptions;

use Throwable;

class NamedRouteException extends RouteException
{
    public function __construct(string $name, string $path, string $currentPath, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Cant add new named route for `%s` because the route name `%s` already exists for the route `%s`', $path, $name, $currentPath), $code, $previous);
    }
}
