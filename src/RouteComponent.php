<?php

declare(strict_types=1);

namespace henrik\route;

use henrik\route\Subscribers\RequestHandlerSubscriber;
use henrik\route\Subscribers\RoutesParserSubscriber;
use Hk\Contracts\ComponentInterface;

class RouteComponent implements ComponentInterface
{
    /**
     * {@inheritDoc}
     */
    public function getServices(): array
    {
        return require 'config/services.php';
    }

    public function getControllersPath(): string
    {
        return '';
    }

    public function getTemplatesPath(): string
    {
        return '';
    }

    public function dependsOn(): array
    {
        return [];
    }

    public function getEventSubscribers(): array
    {
        return [
            RequestHandlerSubscriber::class,
            RoutesParserSubscriber::class,
        ];
    }
}