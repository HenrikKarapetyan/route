<?php

use henrik\route\RouteDispatcher;
use henrik\sl\DependencyInjector;
use henrik\sl\InjectorModes;

require_once '../vendor/autoload.php';
require_once 'routes.php';

$services = require "services.php";

$injector = DependencyInjector::instance();
$injector->setMode(InjectorModes::AUTO_REGISTER);
$injector->load($services);

/** @var RouteDispatcher $routeDispatcher */
$routeDispatcher = $injector->get(RouteDispatcher::class);

$res = $routeDispatcher->dispatch('/api/home/223131');

$handler = $res->getRouteOptions()->getHandler();
if (is_callable($handler)) {
    $handler();
}

