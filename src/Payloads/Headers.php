<?php

namespace OtherCode\Rest\Payloads;

/**
 * Class Headers
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Payloads
 */
class Headers implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Class constructor
     * @param string|array $headers
     */
    public function __construct($headers = null)
    {
        if (isset($headers)) {
            switch (gettype($headers)) {
                case 'string':
                    $this->parse($headers);
                    break;
                case 'array':
                    foreach ($headers as $header => $value) {
                        $this->offsetSet($header, $value);
                    }
                    break;
            }
        }
    }

    /**
     * Build the headers
     */
    public function build()
    {
        $headers = array();
        foreach (get_object_vars($this) as $header => $value) {
            $headers[] = $header . ": " . (string)$value;
        }
        return $headers;
    }

    /**
     * Parse a header string into the object
     * @param $headers
     */
    public function parse($headers)
    {
        $lines = preg_split("/(\r|\n)+/", $headers, -1, PREG_SPLIT_NO_EMPTY);
        array_shift($lines);

        foreach ($lines as $line) {
            list($name, $value) = explode(':', $line, 2);
            $this->{strtolower(trim($name))} = trim($value);
        }
    }

    /**
     * Return the iterator element
     * @return mixed
     */
    public function getIterator()
    {
        return new \ArrayIterator($this);
    }

    /**
     * Check if an offset exists
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->{strtolower($offset)});
    }

    /**
     * Return an offset
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (isset($this->{$name = strtolower($offset)})) {
            return $this->$name;
        }
        return null;
    }

    /**
     * Set an offset
     * @param string $offset
     * @param string $value
     */
    public function offsetSet($offset, $value)
    {
        $this->{strtolower($offset)} = $value;
    }

    /**
     * Unset an offset
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->{strtolower($offset)});
    }

    /**
     * Return the number of properties
     * @return int
     */
    public function count()
    {
        return count(get_object_vars($this));
    }
}