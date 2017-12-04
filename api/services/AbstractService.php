<?php

namespace PSMASAPI\Services;

/**
 * Class AbstractService
 *
 * @property \Phalcon\Db\Adapter\Pdo\Postgresql $db
 * @property \Phalcon\Config                    $config
 */
abstract class AbstractService extends \Phalcon\DI\Injectable {

  /**
   * Invalid parameters anywhere
   */
  const ERROR_INVALID_PARAMETERS = 10001;

  /**
   * Record already exists
   */
  const ERROR_ALREADY_EXISTS = 10002;
}
