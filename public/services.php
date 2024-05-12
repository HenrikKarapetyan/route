<?php

use henrik\route\Interfaces\RouteCollectorInterface;
use henrik\route\RouteCollector;
use henrik\route\RouteDispatcher;
use henrik\sl\ServiceScope;

return [
    ServiceScope::SINGLETON->value => [
        [
            'id'    => RouteCollectorInterface::class,
            'class' => RouteCollector::class,
        ],
        [
            'id'    => RouteDispatcher::class,
            'class' => RouteDispatcher::class,
        ],
    ],
];