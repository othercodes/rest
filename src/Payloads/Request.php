<?php

namespace OtherCode\Rest\Payloads;

/**
 * Class Request
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class Request
{
    /**
     * Http Method
     * @var string
     */
    public $method;

    /**
     * Url to call
     * @var string
     */
    public $url;

    /**
     * Request headers
     * @var Headers
     */
    public $headers;

    /**
     * Main data to be send
     * @var array|object
     */
    public $body;

    /**
     * Request constructor.
     * @param string $method
     * @param string $url
     * @param array|object $body
     * @param Headers|null $headers
     */
    public function __construct($method = null, $url = null, $body = null, Headers $headers = null)
    {
        $this->method = $method;
        $this->url = $url;
        $this->body = $body;

        $this->setHeaders($headers);
    }

    /**
     * Set the headers
     * @param Headers $headers
     */
    public function setHeaders(Headers $headers = null)
    {
        if (isset($headers)) {
            $this->headers = $headers;
        } else {
            $this->headers = new Headers();
        }
    }
}