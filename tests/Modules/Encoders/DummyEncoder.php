<?php

namespace Tests\Modules\Encoders;


class DummyEncoder extends \OtherCode\Rest\Modules\Encoders\BaseEncoder
{
    protected $methods = 'POST';

    public function encode()
    {

    }
}