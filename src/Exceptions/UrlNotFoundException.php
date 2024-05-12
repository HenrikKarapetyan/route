<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 2/5/2018
 * Time: 11:25 AM.
 */
declare(strict_types=1);

namespace henrik\route\Exceptions;

use Throwable;

/**
 * Class UrlNotFoundException.
 */
class UrlNotFoundException extends RouteException
{
    /**
     * UrlNotFoundException constructor.
     *
     * @param string         $uri
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $uri, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('The requested uri `%s` not found', $uri), $code, $previous);
    }
}