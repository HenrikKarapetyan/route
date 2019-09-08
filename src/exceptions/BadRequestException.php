<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 2/8/2018
 * Time: 11:12 AM
 */

namespace henrik\route\exceptions;


use Throwable;

class BadRequestException extends RouteException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}