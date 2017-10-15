<?php

namespace OtherCode\Rest\Modules\Encoders;

/**
 * Class BaseEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Modules\Encoders
 *
 * @property string $method
 * @property string $url
 * @property \OtherCode\Rest\Payloads\Headers $headers
 * @property string $body
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

        $body = $this->body;
        $method = $this->method;
        if (!empty($body) && isset($method)) {

            if (in_array($this->method, $this->methods)) {
                $this->encode();
            }
        }
    }
}