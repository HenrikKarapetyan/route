<?php


use henrik\route\RouteDispatcher;
use henrik\sl\DependencyInjector;
use henrik\sl\InjectorModes;

require_once '../vendor/autoload.php';
require_once 'routes.php';


$injector = DependencyInjector::instance();
$injector->setMode(InjectorModes::AUTO_REGISTER);

/** @var RouteDispatcher $routeDispatcher */
$routeDispatcher = $injector->get(RouteDispatcher::class);

$res = $routeDispatcher->dispatch('/api/home/1/werw');

var_dump($res);

