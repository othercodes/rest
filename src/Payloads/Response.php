<?php

namespace OtherCode\Rest\Payloads;

/**
 * Class Response
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Payloads
 */
class Response
{

    /**
     * Http status code
     * @var int
     */
    public $code;

    /**
     * The Content Type
     * @var string
     */
    public $content_type;

    /**
     * The Charset
     * @var string
     */
    public $charset;

    /**
     * The response body
     * @var string
     */
    public $body;

    /**
     * The response headers
     * @var \OtherCode\Rest\Payloads\Headers
     */
    public $headers;

    /**
     * The last known error
     * @var \OtherCode\Rest\Core\Error
     */
    public $error;

    /**
     * Metadata array
     * @var array
     */
    public $metadata;

    /**
     * @param null $response
     * @param null $error
     * @param null $metadata
     */
    public function __construct($response = null, $error = null, $metadata = null)
    {
        if (isset($response)) {
            $this->parseResponse($response);
        }

        if (isset($error)) {
            $this->setError($error);
        } else {
            $this->setError(new \OtherCode\Rest\Core\Error());
        }

        if (isset($metadata)) {
            $this->setMetadata($metadata);
        }
    }

    /**
     * Parse the response
     * @param $response
     */
    public function parseResponse($response)
    {
        $response = explode("\r\n\r\n", $response);

        $this->body = array_pop($response);
        if(empty($this->body)){
            $this->body = null;
        }

        $this->headers = new \OtherCode\Rest\Payloads\Headers(array_pop($response));


        if (isset($this->headers['Content-Type'])) {
            $content_type = explode(';', $this->headers['Content-Type']);
            $this->content_type = $content_type[0];
        }

        if (!isset($this->charset)) {
            $this->charset = substr($this->content_type, 5) === 'text/' ? 'iso-8859-1' : 'utf-8';
        }
    }

    /**
     * Set the Metadata
     * @param $metadata
     */
    public function setMetadata($metadata)
    {
        $this->code = $metadata['http_code'];
        $this->metadata = $metadata;
    }

    /**
     * Set the Error
     * @param $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}