<?php

namespace Henrik\Route;

use Henrik\Contracts\AttributeParser\AttributeParserInterface;
use Henrik\Route\Attributes\Route;
use Henrik\Route\Interfaces\RouteGraphInterface;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;

readonly class RouteAttributesParser implements AttributeParserInterface
{
    public function __construct(
        private RouteGraphInterface $routeGraph
    ) {}

    public function parse(?object $attributeClass, ReflectionClass $reflectionClass): void
    {
        /** @var ?Route $routeAttribute */
        $routeAttribute = $attributeClass;

        $handlerClass = $reflectionClass->getName();

        $this->checkIsAbstract($reflectionClass, $handlerClass);

        $this->parseRoutes($routeAttribute, $reflectionClass, $handlerClass);

        /**
         * Here methods call means if the class doesn't have any Route attribute then
         * we're trying to get Route attributes from their methods.
         */
        if (is_null($routeAttribute)) {
            $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
            $this->parseRoutesFromMethods($routeAttribute, $methods, $handlerClass);
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