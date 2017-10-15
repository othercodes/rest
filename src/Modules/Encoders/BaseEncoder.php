<?php

namespace OtherCode\Rest\Modules\Encoders;

/**
 * Class BaseEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Modules\Encoders
 */
abstract class BaseEncoder extends \OtherCode\Rest\Modules\BaseModule implements \OtherCode\Rest\Modules\Encoders\EncoderInterface
{
    /**
     * The content type that trigger the decoder
     * @var string
     */
    protected $methods = array('POST', 'PUT', 'PATCH');

    /**
     * Run the main decode method
     */
    public function run()
    {
        if (!is_array($this->methods)) {
            throw new \OtherCode\Rest\Exceptions\RestException('The "methods" property MUST be an array.');
        }

        if (in_array($this->method, $this->methods)) {
            $this->encode();
        }
    }
}