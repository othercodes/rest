<?php

namespace OtherCode\Rest\Modules\Encoders;

use OtherCode\Rest\Exceptions\RestException;

/**
 * Class JSONEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class JSONEncoder extends BaseEncoder
{
    /**
     * Method
     * @var array
     */
    protected $methods = array('POST');

    /**
     * create a xml rpc document based on the
     * provided data.
     */
    public function encode()
    {
        /**
         * Perform the main encode and check if
         * there are any errors.
         */
        $this->body = json_encode($this->body);

        $error = null;
        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
        }

        /**
         * if there are an error we
         * throw an exception
         */
        if (isset($error)) {
            throw new RestException($error);
        }
    }
}