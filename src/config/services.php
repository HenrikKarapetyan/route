<?php

use Henrik\Route\Interfaces\RouteDispatcherInterface;
use Henrik\Route\Interfaces\RouteFinderInterface;
use Henrik\Route\RouteDispatcher;
use Henrik\Route\RouteFinder;
use Henrik\Route\RouteGraph;
use Henrik\Route\Subscribers\RoutesParserSubscriber;
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
            'id'    => RoutesParserSubscriber::class,
            'class' => RoutesParserSubscriber::class,
        ],
    ],

    ServiceScope::PROTOTYPE->value => [
        [
            'id'    => RouteFinderInterface::class,
            'class' => RouteFinder::class,
        ],
    ],
];