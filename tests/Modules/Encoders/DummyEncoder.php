<?php

namespace Tests\Modules\Encoders;


use OtherCode\Rest\Modules\Encoders\BaseEncoder;

class DummyEncoder extends BaseEncoder
{
    protected $methods = 'POST';

    public function encode()
    {

    }
}