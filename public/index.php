<?php

use henrik\route\RouteCollector;
use henrik\route\RouteConstraints;
use henrik\route\RouteDispatcher;
use henrik\sl\DependencyInjector;
use henrik\sl\InjectorModes;

require_once '../vendor/autoload.php';

$injector = DependencyInjector::instance();

$injector->setMode(InjectorModes::AUTO_REGISTER);

/** @var RouteCollector $routeCollector */
$routeCollector = $injector->get(RouteCollector::class);
$routeCollector->add(['GET', 'POST'], '/home/{id}/{page}', function () {
    return 'ok';
}, function (RouteConstraints $constraints) {
    $constraints->set(['id'])->asInteger(1, 34);
    $constraints->set(['page'])->asString();
},['simple', 'xxx']);

/** @var RouteDispatcher $routeDispatcher */
$routeDispatcher = $injector->get(RouteDispatcher::class);

$res = $routeDispatcher->dispatch('/home/1/werw');

var_dump($res);

