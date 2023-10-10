<?php

use OtherCode\Rest\Exceptions\ModuleNotFoundException;
use OtherCode\Rest\Rest;
use OtherCode\Rest\Exceptions\RestException;

test('JSON decoder off', function () {
    $api = new Rest();
    $api->configuration->url = "https://run.mocky.io";

    $response = $api->get("/v3/150aee50-5361-46e1-b7ce-6c67f3985fe7");
    expect($response->body)->toBeString();

    return $api;
});

test('set JSON decoder', function (Rest $api) {
    expect($api->setDecoder("json"))->toBeInstanceOf(Rest::class);
    return $api;
})->depends('JSON decoder off');

test('JSON decoder on', function (Rest $api) {
    $response = $api->get("/v3/150aee50-5361-46e1-b7ce-6c67f3985fe7");

    expect($response->body)->toBeObject();
    expect($response->body)->toBeInstanceOf('\stdClass');
})->depends('set JSON decoder');

test('JSON decoder on fail', function (Rest $api) {
    $api->get("/v3/c288e024-7c1c-4233-9c53-6f6af83df800");
})->throws(RestException::class)->depends('set JSON decoder');

test('XML decoder off', function () {
    $api = new Rest();
    $api->configuration->url = "https://run.mocky.io";

    $response = $api->get("/v2/59db37720f0000220402a676");
    expect($response->body)->toBeString();

    return $api;
});

test('set XML decoder', function (Rest $api) {
    expect($api->setDecoder("xml"))->toBeInstanceOf(Rest::class);
    return $api;
})->depends('XML decoder off');

test('XML decoder on', function (Rest $api) {
    $response = $api->get("/v3/3939c8c3-46fe-423d-abb7-b57ac4eadb86");

    expect($response->body)->toBeObject();
    expect($response->body)->toBeInstanceOf(SimpleXMLElement::class);
})->depends('set XML decoder');

test('exception on bad decoder', function () {
    $api = new Rest();
    $api->setDecoder('non_existant_decoder');
})->throws(ModuleNotFoundException::class);

test('decoder on 204 response', function () {
    $api = new Rest();
    $api->configuration->url = "https://run.mocky.io";
    $api->setDecoder("json");

    $response = $api->get("/v3/150aee50-5361-46e1-b7ce-6c67f3985fe7");
    expect($response->body)->toBeObject();

    $response = $api->get("/v3/a6f75a45-b2f1-4e7c-9ef7-851eff99fac1");
    expect($response->body)->toBeNull();
});

test('XML-RPC decoder off', function () {
    $api = new Rest();
    $api->configuration->url = "https://run.mocky.io";

    $response = $api->get("/v3/35d914d0-0934-4abb-9f8f-7a656e425c1e");
    expect($response->body)->toBeString();

    return $api;
});

test('set XML-RPC decoder', function (Rest $api) {
    expect($api->setDecoder("xmlrpc"))->toBeInstanceOf(Rest::class);
    return $api;
})->depends('XML-RPC decoder off');

test('XML-RPC decoder on', function (Rest $api) {
    $response = $api->get("/v3/35d914d0-0934-4abb-9f8f-7a656e425c1e");

    expect($response->body)->toBeArray();
})->depends('set XML-RPC decoder');
