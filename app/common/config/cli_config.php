<?php

use Phalcon\Config;

defined('BASE_PATH') || define('BASE_PATH', realpath('.'));
defined('APP_PATH') || define('APP_PATH', realpath(BASE_PATH . '/app'));

return new Config(include APP_PATH . '/common/config/config.php');
