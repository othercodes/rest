<?php

namespace OtherCode\Rest\Payloads;

use OtherCode\Rest\Core\Error;

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
    public int $code;

    /**
     * The Content Type
     * @var string
     */
    public string $content_type;

    /**
     * The Charset
     * @var string
     */
    public string $charset;

    /**
     * The response body
     * @var mixed
     */
    public $body;

    /**
     * The response headers
     * @var Headers
     */
    public Headers $headers;

    /**
     * The last known error
     * @var Error
     */
    public Error $error;

    /**
     * Metadata array
     * @var array
     */
    public array $metadata;

    /**
     * @param  null  $response
     * @param  Error|null  $error
     * @param  null  $metadata
     */
    public function __construct($response = null, Error $error = null, $metadata = null)
    {
        if (isset($response)) {
            $this->parseResponse($response);
        }

        if (isset($error)) {
            $this->setError($error);
        } else {
            $this->setError(new Error());
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
        if (empty($this->body)) {
            $this->body = null;
        }

        $this->headers = new Headers(array_pop($response));

        if (isset($this->headers['Content-Type'])) {
            $content_type = explode(';', $this->headers['Content-Type']);
            $this->content_type = $content_type[0];
        }

        if (!isset($this->charset)) {
            $this->charset = substr($this->content_type, 5) === 'text/'
                ? 'iso-8859-1'
                : 'utf-8';
        }
    }

    /**
     * Set the Metadata
     * @param  array  $metadata
     */
    public function setMetadata(array $metadata)
    {
        $this->code = $metadata['http_code'];
        $this->metadata = $metadata;
    }

    /**
     * Set the Error
     * @param  Error  $error
     */
    public function setError(Error $error)
    {
        $this->error = $error;
    }
}
