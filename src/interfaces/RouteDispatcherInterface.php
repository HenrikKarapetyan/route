<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/14/2018
 * Time: 3:07 PM.
 */
declare(strict_types=1);

namespace henrik\route\interfaces;

/**
 * Interface RouteDispatcherInterface.
 */
interface RouteDispatcherInterface
{
    /**
     * @return mixed
     */
    public function dispatch(): mixed;
}