<?php

$usersCollection = new \Phalcon\Mvc\Micro\Collection();
$usersCollection->setHandler('\PSMASAPI\Controllers\UsersController', true);
$usersCollection->setPrefix('/user');
$usersCollection->post('/add', 'addAction');
$usersCollection->get('/list', 'getUserListAction');
$usersCollection->put('/{userId:[1-9][0-9]*}', 'updateUserAction');
$usersCollection->delete('/{userId:[1-9][0-9]*}', 'deleteUserAction');
$app->mount($usersCollection);

$app->notFound(
  function () use ($app) {
    $exception =
      new \PSMASAPI\Controllers\HttpExceptions\Http404Exception(
        _('Not found or error in request.'),
        \PSMASAPI\Controllers\AbstractController::ERROR_NOT_FOUND,
        new \Exception('Not found: ' . $app->request->getMethod() . ' ' . $app->request->getURI())
      );
    throw $exception;
  }
);
