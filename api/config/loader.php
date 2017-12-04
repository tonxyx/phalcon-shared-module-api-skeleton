<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
  'PSMASAPI\Services'    => $config->application->servicesDir,
  'PSMASAPI\Controllers' => $config->application->controllersDir,
  'PSMAS\Common\Models'      => $config->application->modelsDir,
]);

$loader->register();
