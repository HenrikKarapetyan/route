<?php

declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Contracts\BaseComponent;
use Henrik\Contracts\ComponentInterfaces\AttributesAndParsersAwareInterface;
use Henrik\Contracts\Enums\ServiceScope;
use Henrik\Events\EventDispatcher;
use Henrik\Route\Attributes\Delete;
use Henrik\Route\Attributes\Get;
use Henrik\Route\Attributes\Head;
use Henrik\Route\Attributes\Patch;
use Henrik\Route\Attributes\Post;
use Henrik\Route\Attributes\Put;
use Henrik\Route\Attributes\Route;
use Henrik\Route\Interfaces\RouteBuilderInterface;
use Henrik\Route\Interfaces\RouteDispatcherInterface;
use Henrik\Route\Interfaces\RouteGraphInterface;
use Henrik\Route\Interfaces\RouteMatcherInterface;

class RouteComponent extends BaseComponent implements AttributesAndParsersAwareInterface
{
    /**
     * {@inheritDoc}
     */
    public function getServices(): array
    {
        return [
            ServiceScope::SINGLETON->value => [
                [
                    'id' => RouteDispatcherInterface::class,
                    'class' => RouteDispatcher::class,
                ],
                [
                    'id' => RouteGraphInterface::class,
                    'class' => RouteGraph::class,
                ],
                [
                    'id' => RouteAttributesParser::class,
                    'class' => RouteAttributesParser::class,
                ],
                [
                    'id' => RouteBuilderInterface::class,
                    'class' => RouteBuilder::class,
                ],
                [
                    'id' => 'routeEventDispatcher',
                    'class' => EventDispatcher::class
                ]
            ],

            ServiceScope::PROTOTYPE->value => [
                [
                    'id' => RouteMatcherInterface::class,
                    'class' => RouteMatcher::class,
                ],
            ],
        ];
    }

    public function getAttributesAndParsers(): array
    {
        return [
            Route::class => RouteAttributesParser::class,
            Get::class => RouteAttributesParser::class,
            Post::class => RouteAttributesParser::class,
            Put::class => RouteAttributesParser::class,
            Patch::class => RouteAttributesParser::class,
            Head::class => RouteAttributesParser::class,
            Delete::class => RouteAttributesParser::class,
        ];
    }
}