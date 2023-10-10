<?php

use OtherCode\Rest\Exceptions\ConnectionException;
use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Payloads\Headers;
use OtherCode\Rest\Payloads\Request;
use OtherCode\Rest\Payloads\Response;
use OtherCode\Rest\Rest;
use OtherCode\Rest\Core\Configuration;
use OtherCode\Rest\Core\Error;
use Tests\Rest\CoreTester;

test('instantiation and configuration', function () {
    $api = new Rest();

    expect($api)->toBeInstanceOf(Rest::class);
    expect($api->configuration)->toBeInstanceOf(Configuration::class);

    $api->configuration->url = "http://jsonplaceholder.typicode.com/";
    $api->configuration->timeout = 10;

    expect($api->configuration->toArray())->toBeArray();

    /**
     * There are 3 options configured by default, so if we configure
     * two we have a total of 5
     */
    expect($api->configuration->toArray())->toHaveCount(5);

    return $api;
});

test('direct configuration', function (Rest $api) {
    $api->addHeader('some_header', "some_value");
    expect($api->configuration->httpheader)->toHaveCount(1);

    $api->addHeaders(array(
        'some_header_1' => 'some_value_1',
        'some_header_2' => 'some_value_2',
    ));
    expect($api->configuration->httpheader)->toHaveCount(3);

    $api->removeHeader('some_header');
    expect($api->configuration->httpheader)->toHaveCount(2);

    $api->removeHeaders(array(
        'some_header_1',
        'some_header_2',
    ));
    expect($api->configuration->httpheader)->toHaveCount(0);
})->depends('instantiation and configuration');

test('get method', function (Rest $api) {
    $response = $api->get("posts/1");

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();

    return $api;
})->depends('instantiation and configuration');

test('post method', function (Rest $api) {
    $response = $api->post("posts", json_encode(array(
        'title' => 'foo',
        'body' => 'bar',
        'userId' => 1
    )));

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
})->depends('instantiation and configuration');

test('put method', function (Rest $api) {
    $response = $api->put("posts/1", json_encode(array(
        'id' => 1,
        'title' => 'foo',
        'body' => 'bar',
        'userId' => 1
    )));

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
})->depends('instantiation and configuration');

test('patch method', function (Rest $api) {
    $response = $api->patch("posts/1", json_encode(array(
        'body' => 'bar',
    )));

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
})->depends('instantiation and configuration');

test('delete method', function (Rest $api) {
    $response = $api->delete("posts/1");

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
})->depends('instantiation and configuration');

test('head method', function (Rest $api) {
    $response = $api->head("posts");

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
    expect($response->body)->toBeNull();
})->depends('instantiation and configuration');

test('payloads', function (Rest $api) {
    $payloads = $api->getPayloads();

    expect($payloads['request'])->toBeInstanceOf(Request::class);
    expect($payloads['response'])->toBeInstanceOf(Response::class);
})->depends('get method');

test('metadata', function (Rest $api) {
    expect($api->getMetadata())->toBeArray();
})->depends('get method');

test('get error', function (Rest $api) {
    expect($api->getError())->toBeInstanceOf(Error::class);
})->depends('instantiation and configuration');

test('exception', function (Rest $api) {
    $api->configuration->url = "http://thisurlnotexists.com/";
    $api->get("posts/1");
})->throws(ConnectionException::class)->depends('instantiation and configuration');

test('core call wrong verb', function () {
    $core = new CoreTester();
    $core->returnCall('wrong', 'http://jsonplaceholder.typicode.com/posts/1');
})->throws(RestException::class);

test('get raw core call', function () {
    $core = new CoreTester();
    $response = $core->returnCall('GET', 'http://jsonplaceholder.typicode.com/posts/1', 'param=value');

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->headers)->toBeInstanceOf(Headers::class);
    expect($response->error)->toBeInstanceOf(Error::class);
    expect($response->metadata)->toBeArray();
    expect($response->code)->toBeInt();
    expect($response->content_type)->toBeString();
    expect($response->charset)->toBeString();
});
