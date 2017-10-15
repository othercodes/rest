<?php

namespace Tests\Modules;


class DummyEncoder extends \OtherCode\Rest\Modules\Encoders\BaseEncoder
{
    protected $methods = array('POST', 'PUT', 'PATCH');

    public function encode()
    {

    }
}