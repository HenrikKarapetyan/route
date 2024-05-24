<?php

declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Contracts\BaseComponent;
use Henrik\Contracts\ComponentInterfaces\AttributesAndParsersAwareInterface;
use Henrik\Contracts\ComponentInterfaces\EventSubscriberAwareInterface;
use Henrik\Contracts\ComponentInterfaces\OnBootstrapAwareInterface;
use Henrik\Contracts\CoreEvents;
use Henrik\Contracts\Http\RequestInterface;
use Henrik\Route\Attributes\Delete;
use Henrik\Route\Attributes\Get;
use Henrik\Route\Attributes\Head;
use Henrik\Route\Attributes\Patch;
use Henrik\Route\Attributes\Post;
use Henrik\Route\Attributes\Put;
use Henrik\Route\Attributes\Route;
use Henrik\Route\Subscribers\RequestHandlerSubscriber;

class RouteComponent extends BaseComponent implements AttributesAndParsersAwareInterface, EventSubscriberAwareInterface, OnBootstrapAwareInterface
{
    /**
     * {@inheritDoc}
     */
    public function getServices(): array
    {
        return require 'config/services.php';
    }

    public function getAttributesAndParsers(): array
    {
        return [
            Route::class  => RouteAttributesParser::class,
            Get::class    => RouteAttributesParser::class,
            Post::class   => RouteAttributesParser::class,
            Put::class    => RouteAttributesParser::class,
            Patch::class  => RouteAttributesParser::class,
            Head::class   => RouteAttributesParser::class,
            Delete::class => RouteAttributesParser::class,
        ];
    }

    public function getEventSubscribers(): array
    {
        return [
            CoreEvents::ROUTE_DISPATCHER_DEFAULT_DEFINITION_ID => [RequestHandlerSubscriber::class],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function onBootstrapDispatchEvents(): array
    {
        return [
            CoreEvents::ROUTE_DISPATCHER_DEFAULT_DEFINITION_ID => [
                RequestInterface::class => CoreEvents::HTTP_REQUEST_EVENTS,
            ],
        ];
    }
}