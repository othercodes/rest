<?php

namespace OtherCode\Rest;

use InvalidArgumentException;
use OtherCode\Rest\Core\Core;
use OtherCode\Rest\Exceptions\ConnectionException;
use OtherCode\Rest\Exceptions\ModuleNotFoundException;
use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Payloads\Response;

/**
 * Perform request to Rest API
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest
 */
class Rest extends Core
{

    /**
     * @param  string  $url
     * @return Response
     * @throws ConnectionException
     * @throws RestException
     */
    public function get(string $url): Response
    {
        return $this->call("GET", $url);
    }

    /**
     * @param  string  $url
     * @param  mixed  $body
     * @return Response
     * @throws ConnectionException
     * @throws RestException
     */
    public function post(string $url, $body = null): Response
    {
        return $this->call("POST", $url, $body);
    }

    /**
     * @param  string  $url
     * @param  mixed  $body
     * @return Response
     * @throws ConnectionException
     * @throws RestException
     */
    public function delete(string $url, $body = null): Response
    {
        return $this->call("DELETE", $url, $body);
    }

    /**
     * @param  string  $url
     * @param  mixed  $body
     * @return Response
     * @throws ConnectionException
     * @throws RestException
     */
    public function put(string $url, $body = null): Response
    {
        return $this->call("PUT", $url, $body);
    }

    /**
     * @param  string  $url
     * @param  mixed  $body
     * @return Response
     * @throws ConnectionException
     * @throws RestException
     */
    public function patch(string $url, $body = null): Response
    {
        return $this->call("PATCH", $url, $body);
    }

    /**
     * @param  string  $url
     * @return Response
     * @throws ConnectionException
     * @throws RestException
     */
    public function head(string $url): Response
    {
        return $this->call('HEAD', $url);
    }

    /**
     * Add a single new header
     * @param  string  $header
     * @param  mixed  $value
     * @return $this
     */
    public function addHeader(string $header, $value): Rest
    {
        $this->configuration->addHeader($header, $value);
        return $this;
    }

    /**
     * Add a bunch of headers
     * @param  array  $headers
     * @return $this
     */
    public function addHeaders(array $headers): Rest
    {
        foreach ($headers as $header => $value) {
            $this->configuration->addHeader($header, $value);
        }
        return $this;
    }

    /**
     * Remove a header
     * @param  string  $header
     * @return $this
     */
    public function removeHeader(string $header): Rest
    {
        $this->configuration->removeHeader($header);
        return $this;
    }

    /**
     * Remove a set of headers
     * @param  array  $headers
     * @return $this
     */
    public function removeHeaders(array $headers): Rest
    {
        $this->configuration->removeHeaders($headers);
        return $this;
    }

    /**
     * Set a new decoder instance
     * @param  string  $name  Decoder unique name
     * @param  string|null  $decoder  Decoder class name with namespace
     * @return $this
     * @throws ModuleNotFoundException
     */
    public function setDecoder(string $name, string $decoder = null): Rest
    {
        if (!isset($decoder)) {
            $decoder = '\OtherCode\Rest\Modules\Decoders\\'.strtoupper($name).'Decoder';
        }

        if (class_exists($decoder)) {
            $this->registerModule($name, new $decoder($this->response), 'after');
        } else {
            throw new ModuleNotFoundException("Decoder $name not found!");
        }
        return $this;
    }

    /**
     * Set a new encoder instance
     * @param  string  $name  Encoder unique name
     * @param  string|null  $encoder  Encoder class name with namespace
     * @return $this
     * @throws ModuleNotFoundException
     */
    public function setEncoder(string $name, string $encoder = null): Rest
    {
        if (!isset($encoder)) {
            $encoder = '\OtherCode\Rest\Modules\Encoders\\'.strtoupper($name).'Encoder';
        }

        if (class_exists($encoder)) {
            $this->registerModule($name, new $encoder($this->request), 'before');
        } else {
            throw new ModuleNotFoundException('Encoder '.$name.' not found!');
        }
        return $this;
    }

    /**
     * Set a new module instance
     * @param  string  $name  Module unique name
     * @param  string  $module  Module class name with namespace
     * @param  string  $hook  The name the hook
     * @return $this
     * @throws ModuleNotFoundException
     * @throws InvalidArgumentException
     */
    public function setModule(string $name, string $module, string $hook = 'after'): Rest
    {
        if (class_exists($module)) {
            switch ($hook) {
                case 'before':
                    $param = $this->request;
                    break;
                case 'after':
                    $param = $this->response;
                    break;
                default:
                    throw new InvalidArgumentException("Invalid hook name!");
            }
            $this->registerModule($name, new $module($param), $hook);
        } else {
            throw new ModuleNotFoundException('Module '.$name.' not found!');
        }
        return $this;
    }

    /**
     * Unset a registered module or decoder
     * @param  string  $moduleName
     * @param  string  $hook
     * @return $this
     */
    public function unsetModule(string $moduleName, string $hook = 'after'): Rest
    {
        $this->unregisterModule($moduleName, $hook);
        return $this;
    }
}
