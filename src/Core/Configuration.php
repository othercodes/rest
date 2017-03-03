<?php

namespace OtherCode\Rest\Core;

/**
 * Class Configuration
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Core
 */
class Configuration extends \OtherCode\Rest\Core\CurlOpts
{
    /**
     * Configuration constructor.
     * @param array $source
     */
    public function __construct($source = array())
    {
        $this->httpheader = new \OtherCode\Rest\Payloads\Headers();

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
     * @param $header
     * @param $value
     * @return $this
     */
    public function addHeader($header, $value)
    {
        $this->httpheader[$header] = $value;
        return $this;
    }

    /**
     * Add a bunch of headers
     * @param array $headers
     * @return $this
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }
        return $this;
    }

    /**
     * Remove a header
     * @param string $header
     * @return $this
     */
    public function removeHeader($header)
    {
        unset($this->httpheader[$header]);
        return $this;
    }

    /**
     * Remove an set of headers
     * @param array $headers
     * @return $this
     */
    public function removeHeaders(array $headers)
    {
        foreach ($headers as $header) {
            $this->removeHeader($header);
        }
        return $this;
    }

    /**
     * Set the basic http auth
     * @param $username
     * @param $password
     * @return $this
     */
    public function basicAuth($username, $password)
    {
        $this->userpwd = $username . '=' . $password;
        return $this;
    }

    /**
     * Add a SSL Certificate
     * @param string $certificate
     * @return $this
     */
    public function setSSLCertificate($certificate)
    {
        $this->sslcert = $certificate;
        return $this;
    }

    /**
     * Set a CA Certificate to validate peers
     * @param string $path
     * @param string $type Can be capath or cainfo
     * @throws \OtherCode\Rest\Exceptions\RestException
     * @return $this
     */
    public function setCACertificates($path, $type)
    {
        if (!in_array($type, array('capath', 'cainfo'))) {
            throw new \OtherCode\Rest\Exceptions\RestException('Invalid param "type" in for ' . __METHOD__ . 'method.');
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
    public function toArray()
    {
        $array = array();
        $allowed = get_class_vars(get_class($this));
        foreach (get_object_vars($this) as $key => $item) {
            if (array_key_exists($key, $allowed) && isset($item)) {
                $array[constant(strtoupper("CURLOPT_" . $key))] = (method_exists($item, 'build') ? $item->build() : $item);
            }
        }
        return $array;
    }
}