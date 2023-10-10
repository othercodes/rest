<?php

namespace OtherCode\Rest\Modules\Decoders;

use OtherCode\Rest\Exceptions\RestException;

/**
 * Class JSONDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Decoders
 */
class JSONDecoder extends BaseDecoder
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected string $contentType = 'application/json';

    /**
     * Decode the data of a request
     * @throws RestException
     */
    public function decode()
    {
        $this->body = json_decode($this->body);

        $errorCode = json_last_error();
        $errorMessage = json_last_error_msg();

        if ($errorCode !== 0 && isset($errorMessage)) {
            throw new RestException($errorMessage, $errorCode);
        }
    }
}
