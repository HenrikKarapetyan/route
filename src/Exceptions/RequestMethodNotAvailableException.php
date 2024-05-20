<?php

namespace Henrik\Route\Exceptions;

use Throwable;

class RequestMethodNotAvailableException extends RouteException
{
    /**
     * @param string         $currentRequestMethod
     * @param array<string>  $availableRequestMethods
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $currentRequestMethod, array $availableRequestMethods, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('The requestMethod `%s` not available! Available methods is `%s`', $currentRequestMethod, implode(',', $availableRequestMethods)), $code, $previous);
    }
}