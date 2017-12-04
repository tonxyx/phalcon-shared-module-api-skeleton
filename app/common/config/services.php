<?php

use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Line as FormatterLine;
use PSMAS\Common\Library\Auth\Auth;
use PSMAS\Common\Library\Acl\Acl;
use PSMAS\Common\Library\Mail\MailDefault as Mail;

/**
 * Register the global configuration as config
 */
$config = $this->config;
$di->setShared('config', function () use ($config) {
  return $config;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
  $url = new UrlResolver();
  $url->setBaseUri($config->application->baseUri);
  return $url;
});

/**
 * Assets manager
 */
$di->setShared('assets', function () {
  return new AssetsManager();
});

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {
  $view = new View();
  $view->setViewsDir($config->application->viewsDir);
  $view->registerEngines([
    '.volt' => function ($view) use ($config) {
      $volt = new VoltEngine($view, $this);

      if (PROD_ENV)
        $volt->setOptions([
          'compiledPath' => $config->application->cacheDir . 'volt/',
          'compiledSeparator' => '_'
        ]);

      return $volt;
    }
  ]);

  return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
  return new DbAdapter([
    'host' => $config->database->host,
    'username' => $config->database->username,
    'password' => $config->database->password,
    'dbname' => $config->database->dbname
  ]);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () use ($config) {
  return new MetaDataAdapter([
    'metaDataDir' => $config->application->cacheDir . 'metaData/'
  ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () use ($config) {
  $session = new SessionAdapter();
  $session->start();
  return $session;
});

/**
 * Crypt service
 */
$di->set('crypt', function () use ($config) {
  $crypt = new Crypt();
  $crypt->setKey($config->application->cryptSalt);
  return $crypt;
});


/**
 * Flash service with custom CSS classes
 */
$di->set('flash', function () {
  return new Flash([
    'error' => 'alert alert-danger',
    'success' => 'alert alert-success',
    'notice' => 'alert alert-info',
    'warning' => 'alert alert-warning',
  ]);
});

// Set up the flash session service
$di->set('flashSession', function () {
  return new FlashSession([
    'error' => 'alert alert-danger',
    'success' => 'alert alert-success',
    'notice' => 'alert alert-info',
    'warning' => 'alert alert-warning',
  ]);
});

/**
 * Custom authentication component
 */
$di->set('auth', function () {
  return new Auth();
});

/**
 * Mail service uses AmazonSES
 */
$di->set('mail', function () {
  return new Mail();
});

/**
 * Setup the private resources, if any, for performance optimization of the ACL.
 */
$di->setShared('AclPrivateResources', function() {
  if (is_readable(APP_PATH . '/common/config/privateResources.php'))
    return include APP_PATH . '/common/config/privateResources.php';

  return [];
});

/**
 * Access Control List
 * Reads privateResource as an array from the config object.
 */
$di->set('acl', function () {
  $acl = new Acl();
  $acl->addPrivateResources($this->getShared('AclPrivateResources'));
  return $acl;
});

/**
 * Memcached cache
 */
$di->setShared('memcache', function () {
  return new Memcached();
});

/**
 * Logger service
 */
$di->set('logger', function ($filename = null, $format = null) use ($config) {
  $format   = $format ?: $config->get('logger')->format;
  $filename = trim($filename ?: $config->get('logger')->filename, '\\/');
  $path     = rtrim($config->get('logger')->path, '\\/') . DIRECTORY_SEPARATOR;

  $formatter = new FormatterLine($format, $config->get('logger')->date);
  $logger    = new FileLogger($path . $filename);

  $logger->setFormatter($formatter);
  $logger->setLogLevel($config->get('logger')->logLevel);

  return $logger;
});
