<?php

namespace Henrik\Route\Tests;

use Henrik\Route\Exceptions\InvalidRangeException;
use Henrik\Route\RouteConstraints;
use Henrik\Route\Utils\RouteParamType;
use PHPUnit\Framework\TestCase;

class RouteConstraintsTest extends TestCase
{
    public function testRouteConstraints(): void
    {
        $routeConstraints = new RouteConstraints();

        $routeConstraints->set('id')->asInteger(1,34);
        $routeConstraints->set('name')->asString(1,34);
        $routeConstraints->set('anyType')->any(2,45);

        $segments = $routeConstraints->getSegments();

        $this->assertIsArray($segments);
        $this->assertArrayHasKey('id', $segments);
        $this->assertArrayHasKey('name', $segments);
        $this->assertArrayHasKey('anyType', $segments);
    }

    public function testRouteConstraintsByArrayValue(): void
    {
        $routeConstraints = new RouteConstraints();

        $routeConstraints->buildFromArray([
            'id' => [
                'type' => RouteParamType::TYPE_INTEGER,
                'from' => 1,
                'to' => 34,
            ],
            'name' => [
                'type' => RouteParamType::TYPE_STRING,
                'from' => 2,
                'to' => 3,
            ],
            'anyType' => [
                'type' => RouteParamType::TYPE_ANY,
                'from' => 4,
                'to' => 5,
            ]
        ]);
        $segments = $routeConstraints->getSegments();

        $this->assertIsArray($segments);
        $this->assertArrayHasKey('id', $segments);
        $this->assertArrayHasKey('name', $segments);
        $this->assertArrayHasKey('anyType', $segments);
    }

    public function testRouteConstraintsRangeByInvalidParams(): void
    {
        $this->expectException(InvalidRangeException::class);
        $routeConstraints = new RouteConstraints();

        $routeConstraints->set('id')->asInteger(-21,34);
    }
}
