<?php

declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Route\Attributes\Delete;
use Henrik\Route\Attributes\Get;
use Henrik\Route\Attributes\Head;
use Henrik\Route\Attributes\Patch;
use Henrik\Route\Attributes\Post;
use Henrik\Route\Attributes\Put;
use Henrik\Route\Attributes\Route;
use Henrik\Route\Subscribers\RequestHandlerSubscriber;
use Hk\Contracts\BaseComponent;

class RouteComponent extends BaseComponent
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
            RequestHandlerSubscriber::class,
        ];
    }
}