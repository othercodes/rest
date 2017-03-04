<?php

namespace OtherCode\Rest\Modules\Decoders;

/**
 * Class JSONDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Decoders
 */
class JSONDecoder extends \OtherCode\Rest\Modules\Decoders\BaseDecoder
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'application/json';

    /**
     * Decode the data of a request
     * @throws \OtherCode\Rest\Exceptions\RestException
     */
    protected function decode()
    {
        /**
         * Preform the actual decode
         */
        $this->body = json_decode($this->body);

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