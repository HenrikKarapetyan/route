<?php

namespace henrik\route\Subscribers;

use henrik\route\Interfaces\RouteDispatcherInterface;
use Hk\Contracts\CoreEvents;
use Hk\Contracts\DependencyInjectorInterface;
use Hk\Contracts\EventSubscriberInterface;
use Hk\Contracts\FunctionInvokerInterface;
use Hk\Contracts\MethodInvokerInterface;
use Hk\Contracts\ServerRequestFromGlobalsInterface;

readonly class RequestHandlerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RouteDispatcherInterface $routeDispatcher,
        private FunctionInvokerInterface $functionInvoker,
        private MethodInvokerInterface $methodInvoker,
        private DependencyInjectorInterface $dependencyInjector
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

        $res = $this->routeDispatcher->dispatch($requestFromGlobals->getUri()->getPath());

        $handler = $res->getRouteOptions()->getHandler();

        if (is_callable($handler)) {
            $this->functionInvoker->invoke($handler, $res->getParams()); // @phpstan-ignore-line

            return;
        }

        $handlerArray = explode('#', $handler);

        /** @var object $controller */
        $controller = $this->dependencyInjector->get($handlerArray[0]);

        if (is_callable($controller) && !isset($handlerArray[1])) {
            $controller($res->getParams());

            return;
        }

        $this->methodInvoker->invoke($controller, $handlerArray[1], $res->getParams());
    }
}