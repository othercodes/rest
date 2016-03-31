<?php namespace OtherCode\Rest\Core;

use Exception;
use OtherCode\Rest\Payloads\Request;
use OtherCode\Rest\Payloads\Response;
use OtherCode\Rest\Modules\BaseModule;
use OtherCode\Rest\Exceptions\RestException;

/**
 * Class SCITRestCore
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
abstract class Core
{

    /**
     * Core version
     */
    const VERSION = "2.5.2";

    /**
     * Configuration class
     * @var Configuration
     */
    public $configuration;

    /**
     * Last known error
     * @var Error
     */
    public $error;

    /**
     * The data to be send
     * @var Request
     */
    protected $request;

    /**
     * Stack with the response data
     * @var Response
     */
    protected $response;

    /**
     * List of loaded modules
     * @var array
     */
    protected $modules = array(
        'before' => array(),
        'after' => array(),
    );

    /**
     * Main curl resource
     * @var resource
     */
    private $curl;

    /**
     * Main constructor
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration = null)
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, true);

        if (isset($configuration)) {
            $this->configuration = $configuration;
        } else {
            $this->configuration = new Configuration();
        }

        $this->response = new Response();
        $this->request = new Request();
        $this->request->setHeaders($this->configuration->httpheader);

        $this->configure();
    }

    /**
     * Configure main options
     * @param Configuration $configuration
     * @throws RestException
     * @return $this
     */
    public function configure(Configuration $configuration = null)
    {
        if (isset($configuration)) {
            $this->configuration = $configuration;
        }
        if (!curl_setopt_array($this->curl, $this->configuration->toArray())) {
            throw new RestException("It has not been possible to configure the instance, check your configuration options");
        }
        return $this;
    }

    /**
     * Method: POST, PUT, GET etc
     * @param string $method
     * @param string $url
     * @param mixed $body
     * @throws RestException
     * @return Response
     */
    protected function call($method, $url, $body = null)
    {
        $method = strtoupper($method);

        $this->request->body = $body;
        $this->request->method = $method;
        $this->request->url = $this->configuration->url . $url;

        /**
         * In case we have some modules attached to
         * "before" hook, we run them here
         */
        $this->dispatchModules('before');

        /**
         * Switch between the different configurations
         * depending the method used
         */
        switch ($method) {
            case "GET":
                curl_setopt($this->curl, CURLOPT_HTTPGET, true);
                if (isset($this->request->body)) {
                    $this->request->url = sprintf("%s?%s", $this->request->url, http_build_query($this->request->body));
                }
                break;
            case "POST":
                curl_setopt($this->curl, CURLOPT_POST, true);
                if (isset($this->request->body)) {
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->request->body);
                }
                break;
            case "PUT":
            case "PATCH":
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
                if (isset($this->request->body)) {
                    curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->request->body);
                }
                break;
            case "DELETE":
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
                if (isset($this->request->body)) {
                    $this->request->url = sprintf("%s?%s", $this->request->url, http_build_query($this->request->body));
                }
                break;
            default:
                throw new RestException('Method "' . $method . '" not supported!');
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
         * possible error and description
         */
        $this->setError(curl_errno($this->curl), curl_error($this->curl));

        $this->response->parseResponse($response);
        $this->response->setMetadata($this->getMetadata());
        $this->response->setError($this->error);

        /**
         * In case we have some modules attached to
         * "after" hook, we run them here
         */
        $this->dispatchModules('after');

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
    public function getPayloads()
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
    public function getMetadata()
    {
        return curl_getinfo($this->curl);
    }

    /**
     * Return the last error.
     * @return Error
     */
    public function getError()
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
     * @param string $hook Hook module name
     * @throws RestException
     */
    private function dispatchModules($hook)
    {
        /**
         * run each module with try catch
         * structure
         */
        foreach ($this->modules[$hook] as $module) {
            try {
                $module->run();
            } catch (Exception $e) {
                /**
                 * Transform the initial exception to a custom one.
                 */
                throw new RestException($e->getMessage(), $e->getCode());
            }
        }
    }

    /**
     * Register a new module instance
     * @param string $moduleName
     * @param BaseModule $moduleInstance
     * @param string $hook
     * @return boolean
     */
    protected function registerModule($moduleName, BaseModule $moduleInstance, $hook)
    {
        if (!in_array($hook, array_keys($this->modules))) {
            return false;
        }
        if (!array_key_exists($moduleName, $this->modules[$hook])) {
            $this->modules[$hook][$moduleName] = $moduleInstance;
            return true;
        }
        return null;
    }

    /**
     * Unregister the module specified by $moduleName
     * @param $moduleName string
     * @param string $hook
     * @return boolean
     */
    protected function unregisterModule($moduleName, $hook)
    {
        if (!in_array($hook, array_keys($this->modules))) {
            return false;
        }
        if (array_key_exists($moduleName, $this->modules[$hook])) {
            unset($this->modules[$hook][$moduleName]);
            return true;
        }
        return null;
    }

    /**
     * Class destructor
     */
    public function __destruct()
    {
        if (gettype($this->curl) == 'resource') {
            curl_close($this->curl);
        }
    }

}