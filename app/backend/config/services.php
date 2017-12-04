<?php

use Phalcon\Mvc\Dispatcher;

/**
 * Dispatcher use a default namespace
 */
$di->set('dispatcher', function () {
  $dispatcher = new Dispatcher();
  $dispatcher->setDefaultNamespace('PSMAS\Backend\Controllers');
  return $dispatcher;
});
