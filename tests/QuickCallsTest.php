<?php

use OtherCode\Rest\Payloads\Request;
use OtherCode\Rest\Payloads\Response;
use OtherCode\Rest\Payloads\Headers;
use OtherCode\Rest\Core\Error;

test('quick get JSON', function () {
    $response = Request::call('http://jsonplaceholder.typicode.com')
        ->setDecoder('json')
        ->get('/posts/1');

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
});

test('quick post JSON', function () {
    $response = Request::call('http://jsonplaceholder.typicode.com')
        ->setEncoder('json')
        ->post("/posts", array(
            'title' => 'foo',
            'body' => 'bar',
            'userId' => 1
        ));

    expect($response)->toBeInstanceOf('\OtherCode\Rest\Payloads\Response');
    expect($response->headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($response->error)->toBeInstanceOf('\OtherCode\Rest\Core\Error');
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
});

test('quick put JSON', function () {
    $response = Request::call('http://jsonplaceholder.typicode.com')
        ->setEncoder('json')
        ->put("/posts/1", array(
            'id' => 1,
            'title' => 'foo',
            'body' => 'bar',
            'userId' => 1
        ));

    expect($response)->toBeInstanceOf('\OtherCode\Rest\Payloads\Response');
    expect($response->headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($response->error)->toBeInstanceOf('\OtherCode\Rest\Core\Error');
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
});

test('quick patch', function () {
    $response = Request::call('http://jsonplaceholder.typicode.com')
        ->setEncoder('json')
        ->patch("/posts/1", array(
            'body' => 'bar',
        ));

    expect($response)->toBeInstanceOf('\OtherCode\Rest\Payloads\Response');
    expect($response->headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($response->error)->toBeInstanceOf('\OtherCode\Rest\Core\Error');
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
});

test('quick delete', function () {
    $response = Request::call('http://jsonplaceholder.typicode.com')
        ->delete("/posts/1");

    expect($response)->toBeInstanceOf('\OtherCode\Rest\Payloads\Response');
    expect($response->headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($response->error)->toBeInstanceOf('\OtherCode\Rest\Core\Error');
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
});

test('quick head', function () {
    $response = Request::call('http://jsonplaceholder.typicode.com')
        ->head("/posts");

    expect($response)->toBeInstanceOf('\OtherCode\Rest\Payloads\Response');
    expect($response->headers)->toBeInstanceOf('\OtherCode\Rest\Payloads\Headers');
    expect($response->error)->toBeInstanceOf('\OtherCode\Rest\Core\Error');
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
    expect($response->body)->toBeNull();
});
