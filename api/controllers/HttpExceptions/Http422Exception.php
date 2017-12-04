<?php

namespace PSMASAPI\Controllers\HttpExceptions;

use PSMASAPI\Controllers\AbstractHttpException;

/**
 * Class Http422Exception
 *
 * Execption class for Unprocessable entity Error (422)
 */
class Http422Exception extends AbstractHttpException
{
    protected $httpCode = 422;
    protected $httpMessage = 'Unprocessable entity';
}
