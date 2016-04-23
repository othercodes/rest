<?php

namespace OtherCode\Rest\Modules\Encoders;

/**
 * Class XMLEncoder
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Rest\Modules\Encoders
 */
class XMLEncoder extends \OtherCode\Rest\Modules\Encoders\BaseEncoder
{
    /**
     * Methods that will trigger the encoder
     * @var array
     */
    protected $methods = array('POST');

    /**
     * The root element
     * @var string
     */
    protected $root = 'root';

    /**
     * create a xml rpc document based on the
     * provided data.
     */
    public function encode()
    {


    }
}