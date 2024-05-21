<?php

namespace Henrik\Route\Subscribers;

use Henrik\Route\Interfaces\RouteDispatcherInterface;
use Hk\Contracts\CoreEvents;
use Hk\Contracts\EventDispatcherInterface;
use Hk\Contracts\EventSubscriberInterface;
use Hk\Contracts\ServerRequestFromGlobalsInterface;

readonly class RequestHandlerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RouteDispatcherInterface $routeDispatcher,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            CoreEvents::HTTP_REQUEST_EVENTS => 'handleServerRequest',
        ];
    }

    /**
     * @param ServerRequestFromGlobalsInterface $events
     */
    public function handleServerRequest(ServerRequestFromGlobalsInterface $events): void
    {

        $requestFromGlobals = $events->getServerRequest();

        $routeData = $this->routeDispatcher->dispatch(
            $requestFromGlobals->getUri()->getPath(),
            $requestFromGlobals->getMethod()
        );

        $this->eventDispatcher->dispatch($routeData, CoreEvents::ROUTE_MATCH_EVENTS);

    }
}