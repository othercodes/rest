<?php

namespace OtherCode\Rest\Modules\Encoders;

use OtherCode\Rest\Exceptions\RestException;

/**
 * Class JSONEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Encoders
 */
class JSONEncoder extends BaseEncoder
{
    /**
     * Method
     * @var array
     */
    protected $methods = array('POST', 'PUT', 'PATCH');

    /**
     * create a xml rpc document based on the provided data.
     * @throws RestException
     */
    public function encode()
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->body = json_encode($this->body);

        $errorCode = json_last_error();
        $errorMessage = json_last_error_msg();

        if ($errorCode !== 0 && isset($errorMessage)) {
            throw new RestException($errorMessage, $errorCode);
        }
    }
}
