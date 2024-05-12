<?php

use henrik\route\RouteGraph;
use henrik\route\RouteConstraints;
use henrik\route\Route;

(new Route())->routes(
    function (RouteGraph $routeCollector) {
        $routeCollector->setGroupName('api');
        $routeCollector->get(
            path: '/home/{id}/{page}',
            handler: function () {
                echo '<h1>hello from basic handler</h1>';
            },
            constraints: function (RouteConstraints $constraints) {
                $constraints->set(['id'])->asInteger(1, 34);
                $constraints->set(['page'])->asString();
            },
            middlewars: ['simple', 'xxx'],
        );

        $routeCollector->get(
            path: '/home/{name}',
            handler: function () {
                echo '<h1>hello Heno</h1>';
            },
            constraints: function (RouteConstraints $constraints) {
                $constraints->set(['nme'])->asString();
            },
            middlewars: ['simple', 'xxx'],
        );
    }
);