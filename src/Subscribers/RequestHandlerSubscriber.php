<?php

namespace Henrik\Route\Subscribers;

use Henrik\Route\Exceptions\RequestMethodNotAvailableException;
use Henrik\Route\Interfaces\RouteDispatcherInterface;
use Hk\Contracts\CoreEvents;
use Hk\Contracts\DependencyInjectorInterface;
use Hk\Contracts\EventSubscriberInterface;
use Hk\Contracts\FunctionInvokerInterface;
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

        $res = $this->routeDispatcher->dispatch($requestFromGlobals->getUri()->getPath());

        $handler = $res->getRouteOptions()->getHandler();

        $this->checkIsRequestMethodsAvailable($requestFromGlobals->getMethod(), $res->getRouteOptions()->getMethod());

        if (is_callable($handler)) {
            $this->functionInvoker->invoke($handler, $res->getParams()); // @phpstan-ignore-line

            return;
        }

        $handlerArray = explode(MarkersInterface::AS_SERVICE_PARAM_MARKER, $handler);

        /** @var object $controller */
        $controller = $this->dependencyInjector->get($handlerArray[0]);

        if (is_callable($controller) && !isset($handlerArray[1])) {
            $controller($res->getParams());

            return;
        }

        $this->methodInvoker->invoke($controller, $handlerArray[1], $res->getParams());
    }

    /**
     * @param string               $requestMethod
     * @param array<string>|string $availableMethods
     *
     * @return void
     */
    private function checkIsRequestMethodsAvailable(string $requestMethod, array|string $availableMethods): void
    {
        if (is_string($availableMethods)) {
            if ($requestMethod !== $availableMethods) {
                throw new RequestMethodNotAvailableException($requestMethod, [$availableMethods]);
            }

            return;
        }

        if (!in_array($requestMethod, $availableMethods)) {
            throw new RequestMethodNotAvailableException($requestMethod, $availableMethods);
        }
    }
}