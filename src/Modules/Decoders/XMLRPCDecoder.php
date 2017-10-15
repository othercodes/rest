<?php namespace OtherCode\Rest\Modules\Decoders;

/**
 * Class XMLRPCDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Decoders
 */
class XMLRPCDecoder extends \OtherCode\Rest\Modules\Decoders\BaseDecoder
{

    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'text/xml';

    /**
     * Decode the data of a request
     */
    public function decode()
    {
        $response = xmlrpc_decode($this->body);

        if (is_array($response) && xmlrpc_is_fault($response)) {
            throw new \OtherCode\Rest\Exceptions\RestException($response['faultString'], $response['faultCode']);
        }

        $this->body = $response;
    }
}