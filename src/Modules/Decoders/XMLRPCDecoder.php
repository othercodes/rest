<?php namespace OtherCode\Rest\Modules\Decoders;


/**
 * Class XMLRPCDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class XMLRPCDecoder extends BaseDecoder
{

    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'text/xml';

    /**
     * Decode the data of a request
     * @return mixed
     */
    public function decode()
    {
        $decode = xmlrpc_decode($this->body);

        if ($decode) {
            $this->body = $decode;
        }

    }

}