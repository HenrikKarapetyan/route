<?php

namespace Henrik\Route\Tests;

use Henrik\Route\Exceptions\NamedRouteException;
use Henrik\Route\RouteConstraints;
use Henrik\Route\RouteGraph;
use Henrik\Route\Utils\RouteParamType;
use PHPUnit\Framework\TestCase;

class RouteGraphTest extends TestCase
{

    private RouteGraph $routeGraph;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routeGraph = new RouteGraph();
        $this->routeGraph->add(
            methods: ['GET'],
            path: '/get/',
            handler: function () {
                return "ok";
            },
            constraints: function (RouteConstraints $constraints) {

            },
            middlewares: [
                'auth'
            ],
            groupName: '/api',
            name: 'getMethodTest'
        );

        $this->routeGraph->add(
            methods: ['POST'],
            path: '/post/',
            handler: 'simpleHandlerClass#simpleHandlerMethod', constraints: function (RouteConstraints $constraints) {
        },
            middlewares: ['auth'],
            groupName: '/api',
            name: 'postMethodTest'
        );

        $this->routeGraph->add(
            methods: ['POST'],
            path: '/get/{id}',
            handler: 'simpleHandlerClass#simpleHandlerMethod', constraints: function (RouteConstraints $constraints) {
            $constraints->set('id')->asString(1, 45);
        },
            middlewares: ['auth'],
            groupName: '/api',
            name: 'parametrizedRoute'
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->routeGraph);
    }

    public function testRouteGraph(): void
    {
        $this->assertEquals('/api/get/', $this->routeGraph->getRouteByName('getMethodTest'));
        $this->assertEquals('/api/post/', $this->routeGraph->getRouteByName('postMethodTest'));
        $this->assertEquals('/api/get/{id}', $this->routeGraph->getRouteByName('parametrizedRoute'));

        $routesGraph = $this->routeGraph->getRoutes();

        $this->assertIsArray($routesGraph);
        $this->assertArrayHasKey('/api', $routesGraph);

    }

    public function testRouteGraphAddRouteBySameName(): void
    {
        $this->expectException(NamedRouteException::class);
        $this->routeGraph->add(
            methods: ['GET'],
            path: '/get/xx',
            handler: function () {
                return "ok";
            },
            constraints: function (RouteConstraints $constraints) {

            },
            middlewares: [
                'auth'
            ],
            groupName: '/api',
            name: 'getMethodTest'
        );
    }

    public function testAddRouteConstraintsByArray(): void
    {
        $this->routeGraph->add(
            methods: ['GET'],
            path: '/get/{id}/{name}',
            handler: function () {
                return "ok";
            },
            constraints: [
                'id' => [
                    'type' => RouteParamType::TYPE_INTEGER,
                    'from' => 1,
                    'to' => 34,
                ],
                'name' => [
                    'type' => RouteParamType::TYPE_STRING,
                    'from' => 1,
                    'to' => 8,
                ]
            ],
            middlewares: [
                'auth'
            ],
            groupName: '/api',
            name: 'byArrayRouteConstraints'
        );

        $this->assertEquals('/api/get/{id}/{name}', $this->routeGraph->getRouteByName('byArrayRouteConstraints'));

    }
}
