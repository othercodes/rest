<?php


class DecodersTest extends \PHPUnit_Framework_TestCase
{

    public function testJSonDecoderOFF()
    {
        $api = new OtherCode\Rest\Rest();
        $api->configuration->url = "http://jsonplaceholder.typicode.com/";

        $response = $api->get("posts/1");
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
        $response = $api->get("posts/1");

        $this->assertInternalType('object', $response->body);
        $this->assertInstanceOf('\stdClass', $response->body);
    }


    public function testXMLDecoderOFF()
    {
        $api = new OtherCode\Rest\Rest();
        $api->configuration->url = "http://www.thomas-bayer.com/";

        $response = $api->get("sqlrest/CUSTOMER/5");
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
        $response = $api->get("sqlrest/CUSTOMER/5");

        $this->assertInternalType('object', $response->body);
        $this->assertInstanceOf('\SimpleXMLElement', $response->body);
    }
}