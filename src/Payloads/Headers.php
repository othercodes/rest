<?php

namespace OtherCode\Rest\Payloads;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * Class Headers
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\Rest\Payloads
 */
class Headers implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Class constructor
     * @param  string|array  $headers
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

    public function build(): array
    {
        $headers = array();
        foreach (get_object_vars($this) as $header => $value) {
            $headers[] = "$header: $value";
        }
        return $headers;
    }

    /**
     * Parse a header string into the object
     * @param  string  $headers
     */
    public function parse(string $headers)
    {
        $lines = preg_split("/(\r|\n)+/", $headers, -1, PREG_SPLIT_NO_EMPTY);
        array_shift($lines);

        foreach ($lines as $line) {
            list($name, $value) = explode(':', $line, 2);
            $this->{strtolower(trim($name))} = trim($value);
        }
    }

    /**
     * Reset the headers content.
     */
    public function reset()
    {
        $headers = array_keys(get_object_vars($this));
        foreach ($headers as $key) {
            $this->offsetUnset($key);
        }
    }

    /**
     * Return the iterator element
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this);
    }

    /**
     * Check if an offset exists
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->{strtolower($offset)});
    }

    /**
     * Return an offset
     * @param  mixed  $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (isset($this->{$name = strtolower($offset)})) {
            return $this->$name;
        }
        return null;
    }

    /**
     * Set an offset
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->{strtolower($offset)} = $value;
    }

    /**
     * Unset an offset
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->{strtolower($offset)});
    }

    /**
     * Return the number of properties
     * @return int
     */
    public function count(): int
    {
        return count(get_object_vars($this));
    }
}
