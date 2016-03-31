<?php

namespace OtherCode\Rest\Core;

/**
 * Class Error
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest
 */
class Error
{
    /**
     * The last error code
     * @var int
     */
    public $code;

    /**
     * The last error message
     * @var string
     */
    public $message;

    /**
     * @param $code
     * @param $message
     */
    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Return if an error exists
     * @return bool
     */
    public function hasError()
    {
        if ($this->code !== 0) {
            return true;
        }
        return false;
    }
}