<?php

use henrik\route\RouteCollector;
use henrik\route\RouteConstraints;
use henrik\route\RouteContainer;

RouteContainer::routes(
    function (RouteCollector $routeCollector) {
        $routeCollector->setGroupName('api');
        $routeCollector->get(
            path: '/home/{id}/{page}',
            handler: function () {
                return 'ok';
            },
            constraints: function (RouteConstraints $constraints) {
                $constraints->set(['id'])->asInteger(1, 34);
                $constraints->set(['page'])->asString();
            },
            middlewars: ['simple', 'xxx'],
        );
    }
);