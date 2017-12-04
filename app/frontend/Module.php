<?php

namespace PSMAS\Frontend;

use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

class Module implements ModuleDefinitionInterface {

  protected $config = null;

  public function __construct (){
    $commonConfig = include APP_PATH . '/common/config/config.php';
    $frontendConfig = include APP_PATH . '/frontend/config/config.php';

    $this->config = new Config(array_replace_recursive(
      $commonConfig,
      $frontendConfig
    ));
  }

  /**
   * Register a specific autoloader for the module
   */
  public function registerAutoloaders (DiInterface $di = null) {
    $commonLoader = include APP_PATH . '/common/config/loader.php';
    $frontendLoader = include APP_PATH . '/frontend/config/loader.php';

    $loader = new Loader();
    $loader->registerNamespaces(array_merge($commonLoader, $frontendLoader))->register();
  }

  /**
   * Register specific services for the module
   */
  public function registerServices (DiInterface $di) {
    include APP_PATH . '/common/config/services.php';
    include APP_PATH . '/frontend/config/services.php';
  }
}
