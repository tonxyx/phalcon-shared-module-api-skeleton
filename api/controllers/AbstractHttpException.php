<?php

namespace PSMASAPI\Controllers;

use PSMASAPI\Services\ServiceException;

/**
 * Class AbstractHttpException
 *
 * Runtime Exceptions
 */
abstract class AbstractHttpException extends \RuntimeException {
    /**
     * Possible fields in the answer body
     */
    const KEY_CODE = 'error';
    const KEY_DETAILS = 'details';
    const KEY_MESSAGE = 'error_description';

    /**
     * http result code
     *
     * @var null
     */
    protected $httpCode = null;

    /**
     * http error message
     *
     * @var null
     */
    protected $httpMessage = null;

    /**
     * Error info
     *
     * @var array
     */
    protected $appError = [];

    /**
     * @param string $appErrorMessage Exception messge
     * @param integer $appErrorCode Exception code
     * @param \Exception $previous Chain of exceptions
     *
     * @throws \RuntimeException
     */
    public function __construct($appErrorMessage = null, $appErrorCode = null, \Exception $previous = null) {
        if (is_null($this->httpCode) || is_null($this->httpMessage)) {
            throw new \RuntimeException('HttpException without httpCode or httpMessage');
        }

        /**
         * Sending ServiceExceptions along the chain
         */
        if ($previous instanceof ServiceException) {
            if (is_null($appErrorCode)) {
                $appErrorCode = $previous->getCode();
            }

            if (is_null($appErrorMessage)) {
                $appErrorMessage = $previous->getMessage();
            }
        }

        $this->appError = [
          self::KEY_CODE => $appErrorCode,
          self::KEY_MESSAGE => $appErrorMessage
        ];

        parent::__construct($this->httpMessage, $this->httpCode, $previous);
    }

    /**
     * Returns client error
     *
     * @return array|null
     */
    public function getAppError()
    {
        return $this->appError;
    }

    /**
     * Adding error array
     *
     * @param array $fields Array with errors
     *
     * @return $this
     */
    public function addErrorDetails(array $fields)
    {
        if (array_key_exists(self::KEY_DETAILS, $this->appError)) {
            $fields = array_merge($this->appError[self::KEY_DETAILS], $fields);
        }
        $this->appError[self::KEY_DETAILS] = $fields;

        // For throw
        return $this;
    }
}
