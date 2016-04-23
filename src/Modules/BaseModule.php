<?php namespace OtherCode\Rest\Modules;

/**
 * Class BaseModule
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
abstract class BaseModule
{
    /**
     * Main data to work with
     * @var \stdClass
     */
    private $bindings;

    /**
     * Class constructor
     * @param $bindings
     */
    public function __construct($bindings)
    {
        $this->bindings = $bindings;
    }

    /**
     * Perform the main module process
     */
    public function run()
    {
        // perform custom actions
    }

    /**
     * Return the processed data
     * @return object
     */
    public function output()
    {
        return $this->bindings;
    }

    /**
     * Provide an access get the linked data
     * @param $key string
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->bindings->$key)) {
            return $this->bindings->$key;
        }
        return null;
    }

    /**
     * Provide an access set the linked data
     * @param $key string
     * @param $value mixed
     * @return mixed
     */
    public function __set($key, $value)
    {
        if (isset($this->bindings->$key)) {
            $this->bindings->$key = $value;
        }
    }

}