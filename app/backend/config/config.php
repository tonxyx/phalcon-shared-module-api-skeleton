<?php

use Phalcon\Config;
use Phalcon\Logger;

return [
  'application' => [
    'controllersDir' => APP_PATH . '/backend/controllers/',
    'modelsDir' => APP_PATH . '/backend/models/',
    'formsDir' => APP_PATH . '/backend/forms/',
    'viewsDir' => APP_PATH . '/backend/views/',
    'baseUri' => '/',
  ],
  'logger' => [
    'path'     => APP_PATH . '/common/logs/',
    'format'   => '%date% [%type%] %message%',
    'date'     => 'D j H:i:s',
    'logLevel' => Logger::DEBUG,
    'filename' => 'app_backend.log',
  ]
];
