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
}