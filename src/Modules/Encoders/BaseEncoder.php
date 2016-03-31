<?php namespace OtherCode\Rest\Modules\Encoders;

use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Modules\BaseModule;

/**
 * Class BaseEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
abstract class BaseEncoder extends BaseModule
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $methods = array('POST');

    /**
     * Perform the main decode of the data
     */
    protected function encode()
    {
        // do something with $this->body
    }

    /**
     * Run the main decode method
     */
    public function run()
    {
        if (!is_array($this->methods)) {
            throw new RestException('The "methods" property MUST be an array.');
        }

        if (in_array($this->method, $this->methods)) {
            $this->encode();
        }
    }
}