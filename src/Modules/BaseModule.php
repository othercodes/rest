<?php

namespace OtherCode\Rest\Modules;

/**
 * Class BaseModule
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest
 */
abstract class BaseModule implements ModuleInterface
{
    /**
     * Main data to work with
     * @var object
     */
    private object $bindings;

    /**
     * Class constructor
     * @param  object  $bindings
     */
    public function __construct(object $bindings)
    {
        $this->bindings = $bindings;
    }

    /**
     * Return the processed data
     * @return object
     */
    public function output(): object
    {
        return $this->bindings;
    }

    /**
     * Provide an access get the linked data
     * @param $key string
     * @return mixed
     */
    public function __get(string $key)
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
     * @return void
     */
    public function __set(string $key, $value)
    {
        if (isset($this->bindings->$key)) {
            $this->bindings->$key = $value;
        }
    }
}
