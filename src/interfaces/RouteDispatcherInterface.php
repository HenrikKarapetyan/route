<?php
/**
 * Created by PhpStorm.
 * User: Henrik
 * Date: 4/14/2018
 * Time: 3:07 PM
 */

namespace henrik\route\interfaces;


/**
 * Interface RouteDispatcherInterface
 * @package henrik\route
 */
interface RouteDispatcherInterface
{
    /**
     * @return mixed
     */
    public function dispatch();
}