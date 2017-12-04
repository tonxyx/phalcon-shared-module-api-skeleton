<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use PSMASAPI\Services\UsersService;

$di = new \Phalcon\DI\FactoryDefault();

/**
 * Overriding Response-object to set the Content-type header globally
 */
$di->setShared('response', function () {
    $response = new \Phalcon\Http\Response();
    $response->setContentType('application/json', 'utf-8');

    return $response;
  }
);

/** Common config */
$di->setShared('config', $config);

/** Database */
$di->set('db', function () use ($config) {
    return new DbAdapter([
      'host'     => $config->database->host,
      'username' => $config->database->username,
      'password' => $config->database->password,
      'dbname'   => $config->database->dbname,
    ]);
  }
);

/** Service to perform operations with the Users */
$di->setShared('usersService', new UsersService());

return $di;
