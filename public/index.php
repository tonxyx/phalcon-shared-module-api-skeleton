<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Application;

define('DEV_ENV', getenv('APPLICATION_ENV') == 'development');
// define('STAGE_ENV', getenv('APPLICATION_ENV') == 'staging');
define('PROD_ENV', getenv('APPLICATION_ENV') == 'production');

if (DEV_ENV) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

/**
 * Define some useful constants
 */
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// The FactoryDefault DI automatically register the right services providing a full stack framework
$di = new FactoryDefault();

/**
 * Specify routes for modules
 * Loading routes from the routes.php file
 */
$di->set('router', function () {
  return require APP_PATH . '/common/config/routes.php';
});

try {

  // Handle the request
  $application = new Application($di);

  // Register modules
  $application->registerModules([
    'frontend' => [
      'className' => 'PSMAS\Frontend\Module',
      'path'      => APP_PATH . '/frontend/Module.php',
    ],
    'backend'  => [
      'className' => 'PSMAS\Backend\Module',
      'path'      => APP_PATH . '/backend/Module.php',
    ]
  ]);

  $response = $application->handle();
  $response->send();
} catch (Exception $e) {
  echo $e->getMessage(), '<br>';
  echo nl2br(htmlentities($e->getTraceAsString()));
}
