<?php

namespace OtherCode\Rest\Modules\Encoders;

/**
 * Class XMLRPCEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
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
         * check if the params offset exists
         * if yes we can do the request
         */
        if (isset($this->data->params)) {
            if (isset($this->data->methodName)) {

                /**
                 * if the methodName also exists we
                 * set the methodName of the request
                 */
                $this->data = xmlrpc_encode_request(
                    $this->data->methodName,
                    $this->data->params
                );

            } else {

                /**
                 * if only the params exists we build a
                 * request using only th params
                 */
                $this->data = xmlrpc_encode($this->data->params);
            }
        }

    }
}