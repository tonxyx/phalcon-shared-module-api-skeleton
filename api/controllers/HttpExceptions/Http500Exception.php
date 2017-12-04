<?php

namespace PSMASAPI\Controllers\HttpExceptions;

use PSMASAPI\Controllers\AbstractHttpException;

/**
 * Class Http500Exception
 *
 * Execption class for Internal Server Error (500)
 */
class Http500Exception extends AbstractHttpException
{
    protected $httpCode = 500;
    protected $httpMessage = 'Internal Server Error';
}
