<?php

namespace OtherCode\Rest\Core;

/**
 * Class Error
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Core
 */
class Error
{
    /**
     * The last error code
     * @var int
     */
    public $code = 0;

    /**
     * The last error message
     * @var string
     */
    public $message;

    /**
     * @param $code
     * @param $message
     */
    public function __construct($code = 0, $message = 'none')
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Return if an error exists
     * @deprecated Will be removed in v2
     * @return bool
     */
    public function hasError()
    {
        if ($this->code !== 0) {
            return true;
        }
        return false;
    }

    /**
     * Return the object in string format
     * @return string
     */
    public function __toString()
    {
        return 'There was a connection error, code: ' . $this->code . ' ' . $this->message;
    }
}