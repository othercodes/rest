<?php

namespace OtherCode\Rest\Modules\Encoders;

use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Modules\BaseModule;
use OtherCode\Rest\Payloads\Headers;

/**
 * Class BaseEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Modules\Encoders
 *
 * @property string $method
 * @property string $url
 * @property Headers $headers
 * @property string $body
 */
abstract class BaseEncoder extends BaseModule implements EncoderInterface
{
    /**
     * The content type that trigger the decoder
     * @var mixed
     */
    protected $methods = ['POST', 'PUT', 'PATCH'];

    /**
     * Run the main decode method
     * @throws RestException
     */
    public function run()
    {
        if (!is_array($this->methods)) {
            throw new RestException('The "methods" property MUST be an array.');
        }

        $body = $this->body;
        $method = $this->method;
        if (!empty($body) && isset($method) && in_array($this->method, $this->methods)) {
            $this->encode();
        }
    }
}
