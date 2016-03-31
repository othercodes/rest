<?php namespace OtherCode\Rest\Modules\Decoders;

use SimpleXMLElement;

/**
 * Class SCITRestDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class XMLDecoder extends BaseDecoder
{

    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'application/xml';

    /**
     * Decode the data of a request
     * @return mixed
     */
    public function decode()
    {
        /**
         * Preform the actual decode
         */
        $this->body = new SimpleXMLElement($this->body);

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