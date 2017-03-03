<?php

namespace OtherCode\Rest;

/**
 * Perform request to Rest API
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class Rest extends \OtherCode\Rest\Core\Core
{

    /**
     * @param string $url
     * @return \OtherCode\Rest\Payloads\Response
     */
    public function get($url)
    {
        return $this->call("GET", $url);
    }

    /**
     * @param string $url
     * @param mixed $body
     * @return \OtherCode\Rest\Payloads\Response
     */
    public function post($url, $body = null)
    {
        return $this->call("POST", $url, $body);
    }

    /**
     * @param string $url
     * @param mixed $body
     * @return \OtherCode\Rest\Payloads\Response
     */
    public function delete($url, $body = null)
    {
        return $this->call("DELETE", $url, $body);
    }

    /**
     * @param string $url
     * @param mixed $body
     * @return \OtherCode\Rest\Payloads\Response
     */
    public function put($url, $body = null)
    {
        return $this->call("PUT", $url, $body);
    }

    /**
     * @param string $url
     * @param mixed $body
     * @return \OtherCode\Rest\Payloads\Response
     */
    public function patch($url, $body = null)
    {
        return $this->call("PATCH", $url, $body);
    }

    /**
     * @param $url
     * @return \OtherCode\Rest\Payloads\Response
     */
    public function head($url)
    {
        return $this->call('HEAD', $url);
    }

    /**
     * Add a single new header
     * @param $header
     * @param $value
     * @return $this
     */
    public function addHeader($header, $value)
    {
        $this->configuration->addHeader($header, $value);
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
            $this->configuration->addHeader($header, $value);
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
        $this->configuration->removeHeader($header);
        return $this;
    }

    /**
     * Remove a set of headers
     * @param array $headers
     * @return $this
     */
    public function removeHeaders(array $headers)
    {
        $this->configuration->removeHeaders($headers);
        return $this;
    }

    /**
     * Set a new decoder instance
     * @param string $name Decoder unique name
     * @param string $decoder Decoder class name with namespace
     * @throws \OtherCode\Rest\Exceptions\ModuleNotFoundException
     * @return $this
     */
    public function setDecoder($name, $decoder = null)
    {
        if (!isset($decoder)) {
            $decoder = '\OtherCode\Rest\Modules\Decoders\\' . strtoupper($name) . 'Decoder';
        }

        if (class_exists($decoder, true)) {
            $this->registerModule($name, new $decoder($this->response), 'after');
        } else {
            throw new \OtherCode\Rest\Exceptions\ModuleNotFoundException('Decoder ' . $name . ' not found!');
        }
        return $this;
    }

    /**
     * Set a new encoder instance
     * @param string $name Encoder unique name
     * @param string $encoder Encoder class name with namespace
     * @throws \OtherCode\Rest\Exceptions\ModuleNotFoundException
     * @return $this
     */
    public function setEncoder($name, $encoder = null)
    {
        if (!isset($encoder)) {
            $encoder = '\OtherCode\Rest\Modules\Encoders\\' . strtoupper($name) . 'Encoder';
        }

        if (class_exists($encoder, true)) {
            $this->registerModule($name, new $encoder($this->request), 'before');
        } else {
            throw new \OtherCode\Rest\Exceptions\ModuleNotFoundException('Encoder ' . $name . ' not found!');
        }
        return $this;
    }

    /**
     * Set a new module instance
     * @param string $name Module unique name
     * @param string $module Module class name with namespace
     * @param string $hook The name the hook
     * @throws \InvalidArgumentException
     * @throws \OtherCode\Rest\Exceptions\ModuleNotFoundException
     * @return $this
     */
    public function setModule($name, $module, $hook = 'after')
    {
        if (class_exists($module, true)) {
            switch ($hook) {
                case 'before':
                    $param = $this->request;
                    break;
                case 'after':
                    $param = $this->response;
                    break;
                default:
                    throw new \InvalidArgumentException("Invalid hook name!");
            }
            $this->registerModule($name, new $module($param), $hook);
        } else {
            throw new \OtherCode\Rest\Exceptions\ModuleNotFoundException('Module ' . $name . ' not found!');
        }
        return $this;
    }

    /**
     * Unset a registered module or decoder
     * @param string $moduleName
     * @param string $hook
     * @return $this
     */
    public function unsetModule($moduleName, $hook = 'after')
    {
        $this->unregisterModule($moduleName, $hook);
        return $this;
    }

    /**
     * Return if an error exists
     * @deprecated
     * @return bool
     */
    public function hasError()
    {
        if ($this->response->code !== 0) {
            return true;
        }
        return false;
    }
}