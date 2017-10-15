<?php


class EncodersTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @expectedException \OtherCode\Rest\Exceptions\ModuleNotFoundException
     */
    public function testEncoderNotFound()
    {
        $api = new OtherCode\Rest\Rest();
        $api->setEncoder('nonExistentEncoder');
    }

    /**
     * @expectedException \OtherCode\Rest\Exceptions\RestException
     */
    public function testDecoderOnWrongMethod()
    {
        $api = new OtherCode\Rest\Rest();
        $api->configuration->url = "http://www.mocky.io";

        $api->setEncoder('dummy', '\Tests\Modules\Encoders\DummyEncoder');
        $api->post("/v2/59db36550f0000120402a66f");
    }
}