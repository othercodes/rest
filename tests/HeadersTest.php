<?php

use OtherCode\Rest\Payloads\Headers;

test('construct with string', function () {
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

    $headers = new Headers($rawHeaders);
    expect($headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($headers)->toHaveCount(14);
});

test('construct with array', function () {
    $arrayHeaders = array(
        'some_header' => 'some_value',
        'other_header' => 'other_value'
    );

    $headers = new Headers($arrayHeaders);
    expect($headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($headers)->toHaveCount(2);

    return $headers;
});

test('build headers', function (Headers $headers) {
    expect($headers->build())->toBeArray();
    expect($headers)->toHaveCount(2);
})->depends('construct with array');

test('reset headers', function () {
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

    $headers = new Headers($rawHeaders);
    expect($headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($headers)->toHaveCount(14);

    $headers->reset();
    expect($headers)->toHaveCount(0);
});

test('get array iterator', function () {
    $headers = new Headers();
    expect($headers->getIterator())->toBeInstanceOf('\ArrayIterator');
});

test('get values', function (Headers $headers) {
    expect($headers->offsetGet('nonExistantHeader'))->toBeNull();
    expect($headers->offsetGet('some_header'))->toEqual('some_value');
})->depends('construct with array');
