<?php

namespace Tests\Modules;


class DummyDecoder extends \OtherCode\Rest\Modules\Decoders\BaseDecoder
{
    protected $contentType = 'application/json';

    public function decode()
    {

    }
}