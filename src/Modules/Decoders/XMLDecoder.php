<?php namespace OtherCode\Rest\Modules\Decoders;

/**
 * Class XMLDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Decoders
 */
class XMLDecoder extends \OtherCode\Rest\Modules\Decoders\BaseDecoder
{

    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'application/xml';

    /**
     * Decode the data of a request
     */
    public function decode()
    {
        try {

            $this->body = new \SimpleXMLElement($this->body, LIBXML_NOWARNING);
        } catch (\Exception $e) {

            throw new \OtherCode\Rest\Exceptions\RestException($e->getMessage(), $e->getCode());
        }
    }
}