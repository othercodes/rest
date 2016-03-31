<?php

namespace OtherCode\Rest\Core;

use OtherCode\Rest\Payloads\Headers;

/**
 * Class Configuration
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class Configuration extends CurlOpts
{
    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->httpheader = new Headers();
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