<?php

namespace OtherCode\Rest\Core;

/**
 * Class Error
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Core
 */
class Error
{
    /**
     * The last error code
     * @var int
     */
    public int $code = 0;

    /**
     * The last error message
     * @var string
     */
    public string $message;

    /**
     * @param  int  $code
     * @param  string  $message
     */
    public function __construct(int $code = 0, string $message = 'none')
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Return if an error exists
     * @return bool
     * @deprecated Will be removed in v2
     */
    public function hasError(): bool
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
    public function __toString(): string
    {
        return 'There was a connection error, code: '.$this->code.' '.$this->message;
    }
}
