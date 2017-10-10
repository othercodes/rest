<?php

class QuickCallsTest extends \PHPUnit\Framework\TestCase
{

    public function testQuickGetJSON()
    {
        $response = \OtherCode\Rest\Payloads\Request::call('http://jsonplaceholder.typicode.com')
            ->setDecoder('json')
            ->get('/posts/1');

        $this->assertInstanceOf('OtherCode\Rest\Payloads\Response', $response);
        $this->assertInstanceOf('OtherCode\Rest\Payloads\Headers', $response->headers);
        $this->assertInstanceOf('OtherCode\Rest\Core\Error', $response->error);

        $this->assertInternalType('array', $response->metadata);
        $this->assertInternalType('int', $response->code);
        $this->assertInternalType('string', $response->content_type);
        $this->assertInternalType('string', $response->charset);
    }

    public function testQuickPostJSON()
    {
        $response = \OtherCode\Rest\Payloads\Request::call('http://jsonplaceholder.typicode.com')
            ->setEncoder('json')
            ->post("/posts", array(
                'title' => 'foo',
                'body' => 'bar',
                'userId' => 1
            ));

        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $response);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $response->headers);
        $this->assertInstanceOf('\OtherCode\Rest\Core\Error', $response->error);

        $this->assertInternalType('array', $response->metadata);
        $this->assertInternalType('int', $response->code);
        $this->assertInternalType('string', $response->content_type);
        $this->assertInternalType('string', $response->charset);
    }

    public function testQuickPutJSON()
    {
        $response = \OtherCode\Rest\Payloads\Request::call('http://jsonplaceholder.typicode.com')
            ->setEncoder('json')
            ->put("/posts/1", array(
                'id' => 1,
                'title' => 'foo',
                'body' => 'bar',
                'userId' => 1
            ));

        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $response);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $response->headers);
        $this->assertInstanceOf('\OtherCode\Rest\Core\Error', $response->error);

        $this->assertInternalType('array', $response->metadata);
        $this->assertInternalType('int', $response->code);
        $this->assertInternalType('string', $response->content_type);
        $this->assertInternalType('string', $response->charset);

    }

    public function testQuickPatch()
    {
        $response = \OtherCode\Rest\Payloads\Request::call('http://jsonplaceholder.typicode.com')
            ->setEncoder('json')
            ->patch("/posts/1", array(
                'body' => 'bar',
            ));

        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $response);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $response->headers);
        $this->assertInstanceOf('\OtherCode\Rest\Core\Error', $response->error);

        $this->assertInternalType('array', $response->metadata);
        $this->assertInternalType('int', $response->code);
        $this->assertInternalType('string', $response->content_type);
        $this->assertInternalType('string', $response->charset);
    }

    public function testQuickDelete()
    {
        $response = \OtherCode\Rest\Payloads\Request::call('http://jsonplaceholder.typicode.com')
            ->delete("/posts/1");

        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $response);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $response->headers);
        $this->assertInstanceOf('\OtherCode\Rest\Core\Error', $response->error);

        $this->assertInternalType('array', $response->metadata);
        $this->assertInternalType('int', $response->code);
        $this->assertInternalType('string', $response->content_type);
        $this->assertInternalType('string', $response->charset);
    }

    public function testQuickHead()
    {
        $response = \OtherCode\Rest\Payloads\Request::call('http://jsonplaceholder.typicode.com')
            ->head("/posts");

        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $response);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $response->headers);
        $this->assertInstanceOf('\OtherCode\Rest\Core\Error', $response->error);

        $this->assertInternalType('array', $response->metadata);
        $this->assertInternalType('int', $response->code);
        $this->assertInternalType('string', $response->content_type);
        $this->assertInternalType('string', $response->charset);

        $this->assertNull($response->body);
    }

}