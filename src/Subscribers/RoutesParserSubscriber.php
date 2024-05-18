<?php

namespace Henrik\Route\Subscribers;

use Henrik\Route\Attributes\Route;
use Henrik\Route\RouteGraph;

use Hk\Contracts\AttributeParser\AbstractAttributeParser;
use Hk\Contracts\DetectedClassesEvent;
use Hk\Contracts\EventInterface;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

class RoutesParserSubscriber extends AbstractAttributeParser
{
    public function __construct(
        private readonly RouteGraph $routeGraph
    ) {}

    /**
     * @param EventInterface $event
     */
    public function onParseAttributes(EventInterface $event): void
    {
        if ($event instanceof DetectedClassesEvent) {
            foreach ($event->getDetectedClasses() as $class) {
                $classRoute = null;

                if (class_exists($class)) {
                    $reflectionClass = new ReflectionClass($class);

                    $handlerClass = $reflectionClass->getName();

                    if ($reflectionClass->isAbstract()) {
                        throw new RuntimeException(
                            sprintf('The handler class `%s` cannot be abstract', $handlerClass)
                        );
                    }

                    $reflectionAttributes = $reflectionClass->getAttributes();

                    foreach ($reflectionAttributes as $reflectionAttribute) {
                        if ($reflectionAttribute->newInstance() instanceof Route) {
                            $classRoute = $reflectionAttribute->newInstance();
                        }
                    }

                    $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

                    if (!is_null($classRoute) && count($methods) == 0) {
                        throw new RuntimeException('Handler method doesnt set!');
                    }

                    if (!is_null($classRoute) && $reflectionClass->hasMethod('__invoke')) {

                        $this->routeGraph->add(
                            methods: $classRoute->methods,
                            path: $classRoute->path,
                            handler: $handlerClass,
                            constraints: $classRoute->constraints,
                            middlewars: $classRoute->middlewares
                        );
                    }

                    $this->parseRoutesFromMethods($classRoute, $methods, $handlerClass);
                }
            }
        }
    }

    /**
     * @param array<ReflectionMethod> $methods
     * @param string                  $handlerClass
     * @param ?Route                  $classRoute
     *
     * @return void
     */
    private function parseRoutesFromMethods(?Route $classRoute, array $methods, string $handlerClass): void
    {

        foreach ($methods as $method) {

            $handlerMethod = $method->getName();

            if ($method->isAbstract()) {
                throw new RuntimeException(
                    sprintf('The handler method `%s` cannot be abstract', $handlerMethod)
                );
            }

            if ($method->isConstructor()) {
                continue;
            }

            $attributes = $method->getAttributes();

            foreach ($attributes as $attribute) {

                $methodAttribute = $attribute->newInstance();

                if ($methodAttribute instanceof Route) {
                    $rootPath = $classRoute->path ?? '';
                    $this->routeGraph->add(
                        methods: $methodAttribute->methods,
                        path: $rootPath . $methodAttribute->path,
                        handler: sprintf('%s#%s', $handlerClass, $handlerMethod),
                        constraints: $methodAttribute->constraints,
                        middlewars: $methodAttribute->middlewares
                    );
                }
            }

        }
    }
}