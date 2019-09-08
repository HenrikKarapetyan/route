<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 2/5/2018
 * Time: 11:25 AM
 */

namespace henrik\route\exceptions;


use Throwable;

/**
 * Class UrlNotFoundException
 * @package henrik\route\exceptions
 */
class UrlNotFoundException extends RouteException
{
    /**
     * UrlNotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "The requested url not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}