<?php

use henrik\route\Interfaces\RouteFinderInterface;
use henrik\route\RouteDispatcher;
use henrik\route\RouteFinder;
use henrik\sl\ServiceScope;

return [
    ServiceScope::SINGLETON->value => [
        [
            'id'    => RouteDispatcher::class,
            'class' => RouteDispatcher::class,
        ],
        [
            'id'    => RouteFinderInterface::class,
            'class' => RouteFinder::class,
        ],
    ],
];