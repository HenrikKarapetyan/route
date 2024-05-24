<?php

namespace Henrik\Route\Subscribers;

use Henrik\Contracts\CoreEvents;
use Henrik\Contracts\EventDispatcherInterface;
use Henrik\Contracts\EventSubscriberInterface;
use Henrik\Contracts\ServerRequestFromGlobalsInterface;
use Henrik\Route\Interfaces\RouteDispatcherInterface;

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