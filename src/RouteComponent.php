<?php

declare(strict_types=1);

namespace henrik\route;

use henrik\route\Subscribers\RequestHandlerSubscriber;
use henrik\route\Subscribers\RoutesParserSubscriber;
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