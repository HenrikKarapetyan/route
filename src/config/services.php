<?php

use Henrik\Route\Interfaces\RouteBuilderInterface;
use Henrik\Route\Interfaces\RouteDispatcherInterface;
use Henrik\Route\Interfaces\RouteGraphInterface;
use Henrik\Route\Interfaces\RouteMatcherInterface;
use Henrik\Route\RouteAttributesParser;
use Henrik\Route\RouteBuilder;
use Henrik\Route\RouteDispatcher;
use Henrik\Route\RouteGraph;
use Henrik\Route\RouteMatcher;
use Hk\Contracts\Enums\ServiceScope;

return [
    ServiceScope::SINGLETON->value => [
        [
            'id'    => RouteDispatcherInterface::class,
            'class' => RouteDispatcher::class,
        ],
        [
            'id'    => RouteGraphInterface::class,
            'class' => RouteGraph::class,
        ],
        [
            'id'    => RouteAttributesParser::class,
            'class' => RouteAttributesParser::class,
        ],
        [
            'id'    => RouteBuilderInterface::class,
            'class' => RouteBuilder::class,
        ],
    ],

    ServiceScope::PROTOTYPE->value => [
        [
            'id'    => RouteMatcherInterface::class,
            'class' => RouteMatcher::class,
        ],
    ],
];