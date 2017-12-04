<?php

namespace PSMASAPI\Controllers\HttpExceptions;

use PSMASAPI\Controllers\AbstractHttpException;

/**
 * Class Http400Exception
 *
 * Execption class for Bad Request Error (400)
 */
class Http400Exception extends AbstractHttpException
{
    protected $httpCode = 400;
    protected $httpMessage = 'Bad request';
}
