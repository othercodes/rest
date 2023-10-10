<?php

namespace OtherCode\Rest\Core;

use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Payloads\Headers;

/**
 * Class Configuration
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Core
 */
class Configuration extends CurlOpts
{
    /**
     * Configuration constructor.
     * @param  array  $source
     */
    public function __construct(array $source = [])
    {
        $this->httpheader = new Headers();

        $allowed = array_keys(get_class_vars(get_class($this)));
        foreach ($source as $key => $value) {
            if (in_array(strtolower(trim($key)), $allowed)) {
                switch (strtolower(trim($key))) {
                    case 'httpheader':
                        $this->addHeaders($value);
                        break;
                    default:
                        $this->{strtolower(trim($key))} = $value;
                }
            }
        }
    }

    /**
     * Add a single new header
     * @param  string  $header
     * @param  mixed  $value
     * @return $this
     */
    public function addHeader(string $header, $value): Configuration
    {
        $this->httpheader[$header] = $value;
        return $this;
    }

    /**
     * Add a bunch of headers
     * @param  array  $headers
     * @return $this
     */
    public function addHeaders(array $headers): Configuration
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }
        return $this;
    }

    /**
     * Remove a header
     * @param  string  $header
     * @return $this
     */
    public function removeHeader(string $header): Configuration
    {
        unset($this->httpheader[$header]);
        return $this;
    }

    /**
     * Remove a set of headers
     * @param  array  $headers
     * @return $this
     */
    public function removeHeaders(array $headers): Configuration
    {
        foreach ($headers as $header) {
            $this->removeHeader($header);
        }
        return $this;
    }

    /**
     * Set the basic http auth
     * @param  string  $username
     * @param  string  $password
     * @return $this
     */
    public function basicAuth(string $username, string $password): Configuration
    {
        $this->userpwd = $username.'='.$password;
        return $this;
    }

    /**
     * Add a SSL Certificate
     * @param  string  $certificate
     * @return $this
     */
    public function setSSLCertificate(string $certificate): Configuration
    {
        $this->sslcert = $certificate;
        return $this;
    }

    /**
     * Set a CA Certificate to validate peers
     * @param  string  $path
     * @param  string  $type  Can be capath or cainfo
     * @return $this
     * @throws RestException
     */
    public function setCACertificates(string $path, string $type): Configuration
    {
        if (!in_array($type, ['capath', 'cainfo'])) {
            throw new RestException('Invalid param "type" in for '.__METHOD__.'method.');
        }

        $this->ssl_verifypeer = true;
        $this->ssl_verifyhost = 2;
        $this->$type = $path;
        return $this;
    }

    /**
     * Transform the object to array.
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        $allowed = get_class_vars(get_class($this));
        foreach (get_object_vars($this) as $key => $item) {
            if (array_key_exists($key, $allowed) && isset($item)) {
                $array[constant(strtoupper("CURLOPT_".$key))] = ((is_string($item) || is_object($item))
                && method_exists($item, 'build') ? $item->build() : $item);
            }
        }
        return $array;
    }
}
