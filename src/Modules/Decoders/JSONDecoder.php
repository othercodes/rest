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
    public function decode()
    {
        $this->body = json_decode($this->body);

        $errorCode = json_last_error();
        $errorMessage = json_last_error_msg();

        if ($errorCode !== 0 && isset($errorMessage)) {
            throw new \OtherCode\Rest\Exceptions\RestException($errorMessage, $errorCode);
        }
    }
}