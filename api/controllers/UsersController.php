<?php

namespace PSMASAPI\Controllers;

use PSMASAPI\Controllers\HttpExceptions\Http400Exception;
use PSMASAPI\Controllers\HttpExceptions\Http422Exception;
use PSMASAPI\Controllers\HttpExceptions\Http500Exception;
use PSMASAPI\Services\AbstractService;
use PSMASAPI\Services\ServiceException;
use PSMASAPI\Services\UsersService;

/**
 * Operations with Users: CRUD
 */
class UsersController extends AbstractController {
    /**
     * Adding user
     */
    public function addAction() {

	    /** Init Block **/
        $errors = [];
        $data = [];
	    /** End Init Block **/

	    /** Validation Block **/
        $data['login'] = $this->request->getPost('login');
        if (!is_string($data['login']) || !preg_match('/^[A-z0-9_-]{3,16}$/', $data['login'])) {
            $errors['login'] = 'Login must consist of 3-16 latin symbols, numbers or \'-\' and \'_\' symbols';
        }

        $data['password'] = $this->request->getPost('password');
        if (!is_string($data['password']) || !preg_match('/^[A-z0-9_-]{6,18}$/', $data['password'])) {
            $errors['password'] = 'Password must consist of 6-18 latin symbols, numbers or \'-\' and \'_\' symbols';
        }

        $data['first_name'] = $this->request->getPost('first_name');
        if ((!empty($data['first_name'])) && (!is_string($data['first_name']))) {
            $errors['first_name'] = 'String expected';
        }

        $data['last_name'] = $this->request->getPost('last_name');
        if ((!empty($data['last_name'])) && (!is_string($data['last_name']))) {
            $errors['last_name'] = 'String expected';
        }

        if ($errors) {
            $exception = new Http400Exception(_('Input parameters validation error'), self::ERROR_INVALID_REQUEST);
            throw $exception->addErrorDetails($errors);
        }
	    /** End Validation Block **/

	    /** Passing to business logic and preparing the response **/
        try {
            $this->usersService->createUser($data);
        } catch (ServiceException $e) {
            switch ($e->getCode()) {
                case AbstractService::ERROR_ALREADY_EXISTS:
                case UsersService::ERROR_UNABLE_CREATE_USER:
                    throw new Http422Exception($e->getMessage(), $e->getCode(), $e);
                default:
                    throw new Http500Exception(_('Internal Server Error'), $e->getCode(), $e);
            }
        }
	    /** End Passing to business logic and preparing the response  **/
    }

    /**
     * Returns user list
     *
     * @return array
     */
    public function getUserListAction()
    {
        try {
          $userList = $this->usersService->getUserList();
        } catch (ServiceException $e) {
            throw new Http500Exception(_('Internal Server Error'), $e->getCode(), $e);
        }

        return $userList;
    }

     /**
     * Updating existing user
     *
     * @param string $userId
     */
    public function updateUserAction($userId)
    {
        $errors = [];
        $data   = [];

        $data['login'] = $this->request->getPut('login');
        if ((!is_null($data['login'])) && (!is_string($data['login']) || !preg_match(
                    '/^[A-z0-9_-]{3,16}$/',
              $data['login']
            ))
        ) {
            $errors['login'] = 'Login must consist of 3-16 latin symbols, numbers or \'-\' and \'_\' symbols';
        }

        $data['password'] = $this->request->getPut('password');
        if ((!is_null($data['password'])) && (!is_string($data['password']) || !preg_match(
                    '/^[A-z0-9_-]{6,18}$/',
              $data['password']
            ))
        ) {
            $errors['password'] = 'Password must consist of 6-18 latin symbols, numbers or \'-\' and \'_\' symbols';
        }

        $data['old_password'] = $this->request->getPut('old_password');
        if ((!is_null($data['old_password'])) && (!is_string($data['old_password']))) {
            $errors['old_password'] = 'Old password must be a string';
        }

        $data['first_name'] = $this->request->getPut('first_name');
        if ((!is_null($data['first_name'])) && (!is_string($data['first_name']))) {
            $errors['first_name'] = 'String expected';
        }

        $data['last_name'] = $this->request->getPut('last_name');
        if ((!is_null($data['last_name'])) && (!is_string($data['last_name']))) {
            $errors['last_name'] = 'String expected';
        }

        if (!ctype_digit($userId) || ($userId < 0)) {
            $errors['id'] = 'Id must be a positive integer';
        }

        $data['id'] = (int)$userId;

        if ($errors) {
            $exception = new Http400Exception(_('Input parameters validation error'), self::ERROR_INVALID_REQUEST);
            throw $exception->addErrorDetails($errors);
        }

        try {
            $this->usersService->updateUser($data);
        } catch (ServiceException $e) {
            switch ($e->getCode()) {
                case UsersService::ERROR_UNABLE_UPDATE_USER:
                case UsersService::ERROR_USER_NOT_FOUND:
                    throw new Http422Exception($e->getMessage(), $e->getCode(), $e);
                default:
                    throw new Http500Exception(_('Internal Server Error'), $e->getCode(), $e);
            }
        }
    }

    /**
     * Delete an existing user
     *
     * @param string $userId
     */
    public function deleteUserAction($userId)
    {
        if (!ctype_digit($userId) || ($userId < 0)) {
            $errors['userId'] = 'Id must be a positive integer';
        }

        try {
            $this->usersService->deleteUser((int)$userId);
        } catch (ServiceException $e) {
            switch ($e->getCode()) {
                case UsersService::ERROR_UNABLE_DELETE_USER:
                case UsersService::ERROR_USER_NOT_FOUND:
                    throw new Http422Exception($e->getMessage(), $e->getCode(), $e);
                default:
                    throw new Http500Exception(_('Internal Server Error'), $e->getCode(), $e);
            }
        }
    }
}
