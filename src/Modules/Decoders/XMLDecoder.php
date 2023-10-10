<?php
namespace OtherCode\Rest\Modules\Decoders;

use OtherCode\Rest\Exceptions\RestException;
use SimpleXMLElement;

/**
 * Class XMLDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Decoders
 */
class XMLDecoder extends BaseDecoder
{

    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected string $contentType = 'application/xml';

    /**
     * Decode the data of a request
     * @throws RestException
     */
    public function decode()
    {
        try {
            $this->body = new SimpleXMLElement($this->body, LIBXML_NOWARNING);
        } catch (\Exception $e) {
            throw new RestException($e->getMessage(), $e->getCode());
        }
    }
}
