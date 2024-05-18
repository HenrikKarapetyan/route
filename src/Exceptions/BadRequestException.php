<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 2/8/2018
 * Time: 11:12 AM.
 */

declare(strict_types=1);

namespace Henrik\Route\Exceptions;

use Throwable;

class BadRequestException extends RouteException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}