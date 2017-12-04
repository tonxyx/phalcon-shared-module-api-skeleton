<?php

return [
  'database' => [
    'adapter' => 'Mysql',
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => 'password',
    'dbname' => 'psmas'
  ],
  'application' => [
    'modelsCommonDir' => APP_PATH . '/common/models/',
    'formsCommonDir' => APP_PATH . '/common/forms/',
    'libraryCommonDir' => APP_PATH . '/common/library/',
    'cacheDir' => APP_PATH . '/common/cache/',
    'baseUri' => '/',
    'publicUrl' => 'psmas_app.local',
    'cryptSalt' => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D'
  ],
  'mail' => [
    'fromName' => 'PSMAS',
    'fromEmail' => 'your_email@example.com',
    'smtp' => [
      'server' => 'localhost',
      'port' => 25,
      'security' => 'tls',
      'username' => '',
      'password' => ''
    ]
  ],
  'amazon' => [
    'AWSAccessKeyId' => '',
    'AWSSecretKey' => ''
  ],
  // Set to false to disable sending emails (for use in test environment)
  'useMail' => true
];
