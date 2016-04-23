<?php namespace OtherCode\Rest\Modules\Decoders;

/**
 * Class BaseDecoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Modules\Decoders
 */
abstract class BaseDecoder extends \OtherCode\Rest\Modules\BaseModule
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $contentType = 'text/plain';

    /**
     * Perform the main decode of the data
     */
    protected function decode()
    {
        // do something with ->response
    }

    /**
     * Run the main decode method
     */
    public function run()
    {
        /**
         * First we check if the response
         * has any error.
         */
        if ($this->error->code != 0) {
            return false;
        }

        /**
         * match the content type and run the decoder
         */
        if ($this->contentType == $this->content_type) {
            $this->decode();
        }
        return true;
    }
}