<?php

class ErrorTest extends \PHPUnit\Framework\TestCase
{

    public function testInstantiationDefault()
    {
        $error = new \OtherCode\Rest\Core\Error();
        $this->assertEquals(0, $error->code);
        $this->assertEquals('none', $error->message);
        $this->assertFalse($error->hasError());
        $this->assertInternalType('string', $error->__toString());
    }

    public function testInstantiationSample()
    {
        $error = new \OtherCode\Rest\Core\Error(500, "Something has exploded");
        $this->assertEquals(500, $error->code);
        $this->assertEquals("Something has exploded", $error->message);
        $this->assertTrue($error->hasError());
        $this->assertInternalType('string', $error->__toString());
    }
}