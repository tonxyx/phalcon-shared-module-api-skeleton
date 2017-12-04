<?php

return new \Phalcon\Config([
  'database' => [
    'adapter' => 'Mysql',
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => 'password',
    'dbname' => 'psmas',
  ],

  'application' => [
    'controllersDir' => API_PATH . '/controllers/',
    'servicesDir'    => API_PATH . '/services/',
    'modelsDir'      => APP_PATH . '/common/models/',
    'baseUri'        => '/',
  ],
]);
