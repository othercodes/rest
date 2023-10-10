<?php

use OtherCode\Rest\Exceptions\ModuleNotFoundException;
use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Rest;
use Tests\Modules\Encoders\DummyEncoder;

test('encoder not found', function () {
    $api = new Rest();
    $api->setEncoder('nonExistentEncoder');
})->throws(ModuleNotFoundException::class);

test('decoder on wrong method', function () {
    $api = new Rest();
    $api->configuration->url = "http://www.mocky.io";

    $api->setEncoder('dummy', DummyEncoder::class);
    $api->post("/v2/59db36550f0000120402a66f");
})->throws(RestException::class);
