<?php

use henrik\route\Interfaces\RouteDispatcherInterface;
use henrik\route\Interfaces\RouteFinderInterface;
use henrik\route\RouteDispatcher;
use henrik\route\RouteFinder;
use henrik\route\RouteGraph;
use henrik\route\Subscribers\RoutesParserSubscriber;
use Hk\Contracts\Enums\ServiceScope;

return [
    ServiceScope::SINGLETON->value => [
        [
            'id'    => RouteDispatcherInterface::class,
            'class' => RouteDispatcher::class,
        ],
        [
            'id'    => RouteGraph::class,
            'class' => RouteGraph::class,
        ],
        [
            'id'    => RouteFinderInterface::class,
            'class' => RouteFinder::class,
        ],
        [
            'id'    => RoutesParserSubscriber::class,
            'class' => RoutesParserSubscriber::class,
        ],
    ],
];