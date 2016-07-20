<?php

class RestTest extends \PHPUnit_Framework_TestCase
{

    public function testInstantiation()
    {
        $api = new \OtherCode\Rest\Rest();

        $this->assertInstanceOf('\OtherCode\Rest\Rest', $api);
        $this->assertInstanceOf('\OtherCode\Rest\Core\Configuration', $api->configuration);

        return $api;
    }

    /**
     * @depends testInstantiation
     */
    public function testConfiguration(\OtherCode\Rest\Rest $api)
    {
        $api->configuration->url = "http://jsonplaceholder.typicode.com/";
        $api->configuration->timeout = 10;

        $this->assertInternalType('array', $api->configuration->toArray());

        /**
         * There are 3 options configured by default, so if we configure
         * two we have a total of 5
         */
        $this->assertCount(6, $api->configuration->toArray());

        return $api;
    }

    /**
     * @depends testConfiguration
     */
    public function testSetDecoder(\OtherCode\Rest\Rest $api)
    {
        $this->assertInstanceOf('\OtherCode\Rest\Rest', $api->setDecoder("json"));
        return $api;
    }

    /**
     * @depends testSetDecoder
     */
    public function testGetRequest(\OtherCode\Rest\Rest $api)
    {
        $response = $api->get("posts/1");

        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $response);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $response->headers);
        $this->assertInstanceOf('\OtherCode\Rest\Core\Error', $response->error);

        $this->assertInternalType('array', $response->metadata);
        $this->assertInternalType('int', $response->code);
        $this->assertInternalType('string', $response->content_type);
        $this->assertInternalType('string', $response->charset);

        return $api;
    }

    /**
     * @depends testGetRequest
     */
    public function testErrorControl(\OtherCode\Rest\Rest $api)
    {
        $this->assertInstanceOf('\OtherCode\Rest\Core\Error', $api->getError());
        $this->assertInternalType('boolean', $api->getError()->hasError());
    }

    /**
     * @depends testGetRequest
     */
    public function testPayloads(\OtherCode\Rest\Rest $api)
    {
        $payloads = $api->getPayloads();

        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Request', $payloads['request']);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $payloads['response']);
    }

}