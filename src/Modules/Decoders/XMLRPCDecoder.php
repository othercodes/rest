<?php namespace OtherCode\Rest\Modules\Decoders;

use OtherCode\Rest\Exceptions\RestException;

/**
 * Class XMLRPCDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Decoders
 */
class XMLRPCDecoder extends BaseDecoder
{

    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected string $contentType = 'text/xml';

    /**
     * Decode the data of a request
     * @throws RestException
     */
    public function decode()
    {
        $response = xmlrpc_decode($this->body);

        if (is_array($response) && xmlrpc_is_fault($response)) {
            throw new RestException($response['faultString'], $response['faultCode']);
        }

        $this->body = $response;
    }
}
