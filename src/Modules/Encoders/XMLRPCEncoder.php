<?php

namespace OtherCode\Rest\Modules\Encoders;

/**
 * Class XMLRPCEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Encoders
 */
class XMLRPCEncoder extends \OtherCode\Rest\Modules\Encoders\BaseEncoder
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
         * Set the headers as 'text/xml' by default.
         */
        $this->headers['Content-Type'] = 'text/xml';

        /**
         * check if the params offset exists
         * if yes we can do the request
         */
        if (isset($this->body->params)) {
            if (isset($this->body->methodName)) {

                /**
                 * if the methodName also exists we
                 * set the methodName of the request
                 */
                $this->body = xmlrpc_encode_request($this->body->methodName, $this->body->params);

            } else {

                /**
                 * if only the params exists we build a
                 * request using only th params
                 */
                $this->body = xmlrpc_encode($this->body->params);
            }
        }
    }
}