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
        $this->headers['Content-Type'] = 'text/xml';
        if (isset($this->body->params)) {
            if (isset($this->body->methodName)) {
                $this->body = xmlrpc_encode_request($this->body->methodName, $this->body->params);

            } else {
                $this->body = xmlrpc_encode($this->body->params);
            }
        }
    }
}