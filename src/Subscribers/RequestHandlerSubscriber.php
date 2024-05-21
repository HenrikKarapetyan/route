<?php

namespace Henrik\Route\Subscribers;

use Henrik\Route\Interfaces\RouteDispatcherInterface;
use Henrik\Route\Interfaces\RouteInterface;
use Hk\Contracts\CoreEvents;
use Hk\Contracts\DependencyInjectorInterface;
use Hk\Contracts\EventSubscriberInterface;
use Hk\Contracts\FunctionInvokerInterface;
use Hk\Contracts\HandlerTypesEnum;
use Hk\Contracts\MethodInvokerInterface;
use Hk\Contracts\ServerRequestFromGlobalsInterface;
use Hk\Contracts\Utils\MarkersInterface;

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

        $routeData    = $this->routeDispatcher->dispatch($requestFromGlobals->getUri()->getPath());
        $routeOptions = $routeData->getRouteOptions();

        $handler = $routeOptions->getHandler();

        switch ($routeOptions->getHandlerType()) {
            case HandlerTypesEnum::FUNCTION:
                $this->functionInvoker->invoke($handler, $routeData->getParams()); // @phpstan-ignore-line

                break;

            case HandlerTypesEnum::METHOD:
                /** @var string $handler */
                $this->resolveMethodCall($handler, $routeData);

        }

    }

    private function resolveMethodCall(string $handler, RouteInterface $routeData): void
    {

        $handlerArray = explode(MarkersInterface::AS_SERVICE_PARAM_MARKER, $handler);

        /** @var object $controller */
        $controller = $this->dependencyInjector->get($handlerArray[0]);

        if (is_callable($controller) && !isset($handlerArray[1])) {
            $controller($routeData->getParams());

            return;
        }

        $this->methodInvoker->invoke($controller, $handlerArray[1], $routeData->getParams());
    }
}