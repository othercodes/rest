<?php

namespace OtherCode\Rest\Core;

use OtherCode\Rest\Exceptions\ConnectionException;
use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Modules\BaseModule;
use OtherCode\Rest\Payloads\Request;
use OtherCode\Rest\Payloads\Response;

/**
 * Class Core
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Core
 */
abstract class Core
{

    /**
     * Core version
     */
    const VERSION = "1.5.0";

    /**
     * Configuration class
     * @var Configuration
     */
    public Configuration $configuration;

    /**
     * Last known error
     * @var Error
     */
    public Error $error;

    /**
     * The data to be sent
     * @var Request
     */
    protected Request $request;

    /**
     * Stack with the response data
     * @var Response
     */
    protected Response $response;

    /**
     * List of loaded modules
     * @var array
     */
    protected array $modules = array(
        'before' => [],
        'after' => [],
    );

    /**
     * Main curl resource
     * @var resource
     */
    private $curl;

    /**
     * Main constructor
     * @param  Configuration|null  $configuration
     * @throws RestException
     */
    public function __construct(Configuration $configuration = null)
    {
        $this->response = new Response();
        $this->request = new Request();

        $this->configure($configuration);
    }

    /**
     * Configure main options
     * @param  Configuration|null  $configuration
     * @return $this
     */
    public function configure(Configuration $configuration = null): Core
    {
        if (isset($configuration)) {
            $this->configuration = $configuration;
        } else {
            $this->configuration = new Configuration();
        }
        $this->request->setHeaders($this->configuration->httpheader);
        return $this;
    }

    /**
     * Method: POST, PUT, GET etc
     * @param  string  $method
     * @param  string  $url
     * @param  mixed  $body
     * @return Response
     * @throws ConnectionException
     * @throws RestException
     */
    protected function call(string $method, string $url, $body = null): Response
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt_array($this->curl, $this->configuration->toArray());

        $this->request->body = $body;
        $this->request->method = strtoupper($method);

        $this->request->url = isset($this->configuration->url)
            ? $this->configuration->url.$url
            : $url;

        /**
         * In case we have some modules attached to
         * "before" hook, we run them here
         */
        $this->dispatchModules('before');

        /**
         * Switch between the different configurations
         * depending on the method used.
         */
        switch ($this->request->method) {
            case "HEAD":
                curl_setopt($this->curl, CURLOPT_NOBODY, true);
                break;
            case "GET":
            case "DELETE":
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->request->method);
                if (isset($this->request->body)) {
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->request->body);
                }
                break;
            case "POST":
            case "PUT":
            case "PATCH":
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->request->method);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->request->body);
                break;
            default:
                throw new RestException('Method "'.$this->request->method.'" not supported!');
        }

        /**
         * We configure the domain and url where we will
         * make the request ir exists.
         */
        curl_setopt($this->curl, CURLOPT_URL, $this->request->url);

        /**
         * Main execution
         */
        $response = curl_exec($this->curl);

        /**
         * we get the last request headers and the
         * possible error and description. Also,
         * we launch a ConnectionException if needed.
         */
        $this->setError(curl_errno($this->curl), curl_error($this->curl));
        if ($this->error->code !== 0) {
            throw new ConnectionException($this->error->message, $this->error->code);
        }

        $this->response->parseResponse($response);
        $this->response->setMetadata(curl_getinfo($this->curl));
        $this->response->setError($this->error);

        /**
         * In case we have some modules attached to
         * "after" hook, we run them here
         */
        $this->dispatchModules('after');

        /**
         * Close the current connection
         */
        curl_close($this->curl);

        /**
         * Return the final response processed or not
         * by the modules
         */
        return $this->response;
    }

    /**
     * Return the payloads of the las call
     * @return array
     */
    public function getPayloads(): array
    {
        return array(
            'request' => $this->request,
            'response' => $this->response,
        );
    }

    /**
     * Get the curl request headers
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->response->metadata;
    }

    /**
     * Return the last error.
     * @return Error
     */
    public function getError(): Error
    {
        return $this->error;
    }

    /**
     * Set the error code and message if exists
     * @param $code
     * @param $message
     */
    protected function setError($code, $message)
    {
        $this->error = new Error($code, $message);
    }

    /**
     * Run all the registered modules
     * @param  string  $hook  Hook module name
     * @throws RestException
     */
    private function dispatchModules(string $hook)
    {
        foreach ($this->modules[$hook] as $module) {
            if (method_exists($module, 'run')) {
                $module->run();
            }
        }
    }

    /**
     * Register a new module instance
     * @param  string  $moduleName
     * @param  BaseModule  $moduleInstance
     * @param  string  $hook
     * @return boolean
     */
    protected function registerModule(string $moduleName, BaseModule $moduleInstance, string $hook): bool
    {
        if (!in_array($hook, array_keys($this->modules))) {
            return false;
        }
        if (!array_key_exists($moduleName, $this->modules[$hook])) {
            $this->modules[$hook][$moduleName] = $moduleInstance;
            return true;
        }
        return false;
    }

    /**
     * Unregister the module specified by $moduleName
     * @param $moduleName string
     * @param  string  $hook
     * @return boolean
     */
    protected function unregisterModule(string $moduleName, string $hook): bool
    {
        if (!in_array($hook, array_keys($this->modules))) {
            return false;
        }
        if (array_key_exists($moduleName, $this->modules[$hook])) {
            unset($this->modules[$hook][$moduleName]);
            return true;
        }
        return false;
    }

    /**
     * Return the list of registered modules.
     * @param  string|null  $hook
     * @return array
     */
    public function getModules(string $hook = null): array
    {
        if (isset($hook) && in_array($hook, array_keys($this->modules))) {
            return $this->modules[$hook];
        }

        return $this->modules;
    }

}
