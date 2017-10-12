<?php


class DecodersTest extends \PHPUnit\Framework\TestCase
{

    public function testJSonDecoderOFF()
    {
        $api = new OtherCode\Rest\Rest();
        $api->configuration->url = "http://www.mocky.io";

        $response = $api->get("/v2/59db36550f0000120402a66f");
        $this->assertInternalType('string', $response->body);

        return $api;
    }

    /**
     * @depends testJSonDecoderOFF
     */
    public function testSetJSonDecoder(\OtherCode\Rest\Rest $api)
    {
        $this->assertInstanceOf('\OtherCode\Rest\Rest', $api->setDecoder("json"));
        return $api;
    }

    /**
     * @depends testSetJSonDecoder
     */
    public function testJSonDecoderON(\OtherCode\Rest\Rest $api)
    {
        $response = $api->get("/v2/59db36550f0000120402a66f");

        $this->assertInternalType('object', $response->body);
        $this->assertInstanceOf('\stdClass', $response->body);
    }


    public function testXMLDecoderOFF()
    {
        $api = new OtherCode\Rest\Rest();
        $api->configuration->url = "http://www.mocky.io";

        $response = $api->get("/v2/59db37720f0000220402a676");
        $this->assertInternalType('string', $response->body);

        return $api;
    }

    /**
     * @depends testXMLDecoderOFF
     */
    public function testSetXMLDecoder(\OtherCode\Rest\Rest $api)
    {
        $this->assertInstanceOf('\OtherCode\Rest\Rest', $api->setDecoder("xml"));
        return $api;
    }

    /**
     * @depends testSetXMLDecoder
     */
    public function testXMLDecoderON(\OtherCode\Rest\Rest $api)
    {
        $response = $api->get("/v2/59db37720f0000220402a676");

        $this->assertInternalType('object', $response->body);
        $this->assertInstanceOf('\SimpleXMLElement', $response->body);
    }

    /**
     * @expectedException \OtherCode\Rest\Exceptions\ModuleNotFoundException
     */
    public function testExceptionOnBadDecoder()
    {
        $api = new OtherCode\Rest\Rest();
        $api->setDecoder('non_existant_decoder');
    }

    public function testDecoderOn204Response()
    {
        $api = new OtherCode\Rest\Rest();
        $api->configuration->url = "http://www.mocky.io";
        $api->setDecoder("json");

        $response = $api->get("/v2/59db36550f0000120402a66f");
        $this->assertInternalType('object', $response->body);

        $response = $api->get("/v2/59db35850f00000b0402a669");
        $this->assertNull($response->body);
    }
}