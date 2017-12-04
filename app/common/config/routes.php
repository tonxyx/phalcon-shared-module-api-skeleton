<?php

use Phalcon\Mvc\Router;

/*
 * Define custom routes.
 */
$router = new Router();

$router->setDefaultModule('frontend');

$router->add("/login", [
  'module'     => 'backend',
  'controller' => 'session',
  'action'     => 'login'
]);

$router->add('/confirm/{code}/{email}', [
  'module'     => 'backend',
  'controller' => 'user_control',
  'action'     => 'confirmEmail'
]);

$router->add('/reset-password/{code}/{email}', [
  'module'     => 'backend',
  'controller' => 'user_control',
  'action'     => 'resetPassword'
]);

$router->add('/admin', [
  'module'     => 'backend',
  'controller' => 'users',
  'action'     => 'index',
]);

$router->add("/admin/:controller", [
  'module'     => 'backend',
  'controller' => 1,
  'action'     => 'index'
]);

$router->add("/admin/:controller/:action", [
  'module'     => 'backend',
  'controller' => 1,
  'action'     => 2
]);

// Define a route
$router->add('/admin/:controller/:action/:params', [
  'module'     => 'backend',
  'controller' => 1,
  'action'     => 2,
  'params'     => 3,
]);

return $router;
