<?php

namespace Tests\Modules\Decoders;


class DummyDecoder extends \OtherCode\Rest\Modules\Decoders\BaseDecoder
{
    protected $contentType = 'application/json';

    public function decode()
    {

    }
}