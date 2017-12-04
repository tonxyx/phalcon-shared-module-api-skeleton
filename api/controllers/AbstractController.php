<?php

namespace PSMASAPI\Controllers;

/**
 * Class AbstractController
 *
 * @property \Phalcon\Http\Request              $request
 * @property \Phalcon\Http\Response             $htmlResponse
 * @property \Phalcon\Db\Adapter\Pdo\Postgresql $db
 * @property \Phalcon\Config                    $config
 * @property \PSMASAPI\Services\UsersService   $usersService
 * @property \PSMASAPI\Models\Users            $user
 */
abstract class AbstractController extends \Phalcon\DI\Injectable {

    /**
     * Route not found. HTTP 404 Error
     */
    const ERROR_NOT_FOUND = 1;

    /**
     * Invalid Request. HTTP 400 Error.
     */
    const ERROR_INVALID_REQUEST = 2;
}
