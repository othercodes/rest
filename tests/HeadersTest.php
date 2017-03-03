<?php


class HeadersTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructWithString()
    {
        $rawHeaders = 'HTTP/1.1 200 OK
Server: Cowboy
Connection: keep-alive
X-Powered-By: Express
Vary: Origin
Access-Control-Allow-Credentials: true
Cache-Control: no-cache
Pragma: no-cache
Expires: -1
X-Content-Type-Options: nosniff
Content-Type: application/json; charset=utf-8
Content-Length: 292
Etag: W/"124-yv65LoT2uMHrpn06wNpAcQ"
Date: Mon, 07 Mar 2016 09:51:49 GMT
Via: 1.1 vegur';

        $headers = new \OtherCode\Rest\Payloads\Headers($rawHeaders);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $headers);
        $this->assertCount(14, $headers);
    }

    public function testConstructWithArray()
    {
        $arrayHeaders = array(
            'some_header' => 'some_value',
            'other_header' => 'other_value'
        );

        $headers = new \OtherCode\Rest\Payloads\Headers($arrayHeaders);
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Headers', $headers);
        $this->assertCount(2, $headers);

        return $headers;
    }

    /**
     * @depends testConstructWithArray
     */
    public function testBuildHeaders(\OtherCode\Rest\Payloads\Headers $headers)
    {
        $this->assertInternalType('array', $headers->build());
        $this->assertCount(2, $headers);
    }

}