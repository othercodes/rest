<?php

namespace OtherCode\Rest\Modules\Encoders;

/**
 * Class JSONEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Encoders
 */
class JSONEncoder extends \OtherCode\Rest\Modules\Encoders\BaseEncoder
{
    /**
     * Method
     * @var array
     */
    protected $methods = array('POST', 'PUT', 'PATCH');

    /**
     * create a xml rpc document based on the provided data.
     * @throws \OtherCode\Rest\Exceptions\RestException
     */
    public function encode()
    {
        /**
         * Set the headers as 'application/json' by default.
         */
        $this->headers['Content-Type'] = 'application/json';

        /**
         * Perform the main encode and check if
         * there are any errors.
         */
        $this->body = json_encode($this->body);

        $errorCode = json_last_error();
        switch ($errorCode) {
            case JSON_ERROR_DEPTH:
                $errorMessage = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $errorMessage = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $errorMessage = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $errorMessage = 'Syntax error';
                break;
            case JSON_ERROR_UTF8:
                $errorMessage = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
        }

        if ($errorCode !== 0 && isset($errorMessage)) {
            throw new \OtherCode\Rest\Exceptions\RestException($errorMessage, $errorCode);
        }
    }
}