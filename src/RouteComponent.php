<?php

declare(strict_types=1);

namespace Henrik\Route;

use Henrik\Route\Subscribers\RequestHandlerSubscriber;
use Henrik\Route\Subscribers\RoutesParserSubscriber;
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

    public function getEventSubscribers(): array
    {
        return [
            RequestHandlerSubscriber::class,
            RoutesParserSubscriber::class,
        ];
    }
}