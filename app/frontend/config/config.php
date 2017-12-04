<?php

use Phalcon\Logger;

return [
  'application' => [
    'controllersDir' => APP_PATH . '/frontend/controllers/',
    'viewsDir' => APP_PATH . '/frontend/views/',
    'baseUri' => '/',
  ],
  'logger' => [
    'path'     => APP_PATH . '/common/logs/',
    'format'   => '%date% [%type%] %message%',
    'date'     => 'D j H:i:s',
    'logLevel' => Logger::DEBUG,
    'filename' => 'app_frontend.log',
  ]
];
