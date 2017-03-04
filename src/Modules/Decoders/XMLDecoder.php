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
        /**
         * Preform the actual decode
         */
        $this->body = new \SimpleXMLElement($this->body);

        /**
         * set the new error code and message
         */
        if (!$this->body) {
            $errors = libxml_get_errors();
            $this->error->code = $errors['code'];
            $this->error->message = $errors['message'];
        }

    }

}