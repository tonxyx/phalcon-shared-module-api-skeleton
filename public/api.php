<?php

use PSMASAPI\Controllers\AbstractHttpException;

error_reporting(E_ALL);

/**
 * Define some useful constants
 */
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('API_PATH', BASE_PATH . '/api');

try {
	// Loading Configs
	$config = require(API_PATH . '/config/config.php');

	// Autoloading classes
	require API_PATH . '/config/loader.php';

	// Initializing DI container
	/** @var \Phalcon\DI\FactoryDefault $di */
	$di = require API_PATH . '/config/di.php';

	// Initializing application
	$app = new \Phalcon\Mvc\Micro();
	// Setting DI container
	$app->setDI($di);

	// Setting up routing
	require API_PATH . '/config/routes.php';

	// Making the correct answer after executing
	$app->after(
		function () use ($app) {
			// Getting the return value of method
			$return = $app->getReturnedValue();

			if (is_array($return)) {
				// Transforming arrays to JSON
				$app->response->setContent(json_encode($return));
			} elseif (!strlen($return)) {
				// Successful response without any content
				$app->response->setStatusCode('204', 'No Content');
			} else {
				// Unexpected response
				throw new Exception('Bad Response');
			}

			// Sending response to the client
			$app->response->send();
		}
	);

	// Processing request
	$app->handle();
} catch (AbstractHttpException $e) {
	$response = $app->response;
	$response->setStatusCode($e->getCode(), $e->getMessage());
	$response->setJsonContent($e->getAppError());
	$response->send();
} catch (\Phalcon\Http\Request\Exception $e) {
	$app->response->setStatusCode(400, 'Bad request')
    ->setJsonContent([
      AbstractHttpException::KEY_CODE    => 400,
      AbstractHttpException::KEY_MESSAGE => 'Bad request'
    ])
    ->send();
} catch (\Exception $e) {
	// Standard error format
	$result = [
		AbstractHttpException::KEY_CODE    => 500,
		AbstractHttpException::KEY_MESSAGE => 'Some error occurred on the server.'
	];

	// Sending error response
	$app->response->setStatusCode(500, 'Internal Server Error')
    ->setJsonContent($result)
    ->send();
}
