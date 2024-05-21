<?php

namespace Henrik\Route\Subscribers;

use Henrik\Route\Attributes\Route;
use Henrik\Route\Interfaces\RouteGraphInterface;

use Hk\Contracts\AttributeParser\AbstractAttributeParser;
use Hk\Contracts\DetectedClassesEvent;
use Hk\Contracts\EventInterface;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

class RoutesParserSubscriber extends AbstractAttributeParser
{
    public function __construct(
        private readonly RouteGraphInterface $routeGraph
    ) {}

    /**
     * @param EventInterface $event
     */
    public function onParseAttributes(EventInterface $event): void
    {
        if ($event instanceof DetectedClassesEvent) {
            foreach ($event->getDetectedClasses() as $class) {
                $this->parseClassAttributes($class);
            }
        }
    }

    /**
     * @param object|null             $classRoute
     * @param array<ReflectionMethod> $methods
     *
     * @return void
     */
    private function checkIsHandlerIsSet(?object $classRoute, array $methods): void
    {

        if (!is_null($classRoute) && count($methods) == 0) {
            throw new RuntimeException('Handler method doesnt set!');
        }
    }

    private function parseClassAttributes(string $class): void
    {
        $classRoute = null;

        if (class_exists($class)) {
            $reflectionClass = new ReflectionClass($class);

            $handlerClass = $reflectionClass->getName();

            $this->checkIsAbstract($reflectionClass, $handlerClass);

            $reflectionAttributes = $reflectionClass->getAttributes();

            foreach ($reflectionAttributes as $reflectionAttribute) {
                if ($reflectionAttribute->newInstance() instanceof Route) {
                    $classRoute = $reflectionAttribute->newInstance();

                    $this->parseRoutes($classRoute, $reflectionClass, $handlerClass);
                }
            }

            /**
             * Here methods call means if the class doesn't have any Route attribute then
             * we're trying to get Route attributes from their methods.
             */
            if (is_null($classRoute)) {
                $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
                $this->parseRoutesFromMethods($classRoute, $methods, $handlerClass);
            }

        }
    }

    /**
     * @param ReflectionClass<object> $reflectionClass
     * @param string                  $handlerClass
     *
     * @return void
     */
    private function checkIsAbstract(ReflectionClass $reflectionClass, string $handlerClass): void
    {
        if ($reflectionClass->isAbstract()) {
            throw new RuntimeException(
                sprintf('The handler class `%s` cannot be abstract', $handlerClass)
            );
        }
    }

    /**
     * @param Route|null              $classRoute
     * @param ReflectionClass<object> $reflectionClass
     * @param string                  $handlerClass
     *
     * @return void
     */
    private function parseRoutes(?Route $classRoute, ReflectionClass $reflectionClass, string $handlerClass): void
    {
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        $this->checkIsHandlerIsSet($classRoute, $methods);

        if (!is_null($classRoute) && $reflectionClass->hasMethod('__invoke')) {

            $this->routeGraph->add(
                methods: $classRoute->methods,
                path: $classRoute->path,
                handler: $handlerClass,
                constraints: $classRoute->constraints, // @phpstan-ignore-line
                middlewars: $classRoute->middlewares
            );

            if ($classRoute->name) {
                $this->routeGraph->addNamedRoute($classRoute->name, $classRoute->path);
            }
        }

        $this->parseRoutesFromMethods($classRoute, $methods, $handlerClass);
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
                        constraints: $methodAttribute->constraints, // @phpstan-ignore-line
                        middlewars: $methodAttribute->middlewares
                    );

                    if ($methodAttribute->name) {
                        $this->routeGraph->addNamedRoute($methodAttribute->name, $rootPath . $methodAttribute->path);
                    }
                }
            }

        }
    }
}