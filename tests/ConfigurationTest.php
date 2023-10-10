<?php

use OtherCode\Rest\Core\Configuration;
use OtherCode\Rest\Exceptions\RestException;
use OtherCode\Rest\Payloads\Headers;

test('basic instantiation', function () {
    $configuration = new Configuration();
    expect($configuration)->toBeInstanceOf(Configuration::class);
    expect($configuration->toArray())->toBeArray();
    expect($configuration->toArray())->toHaveCount(3);
});

test('instantiation with params', function () {
    $configuration = new Configuration(array(
        'url' => 'http://jsonplaceholder.typicode.com/',
        'thisConfigurationIsNotAllowed' => 'Some invalid value',
        'httpheader' => array(
            'some_header1' => 'some_value1',
            'some_header2' => 'some_value2'
        )
    ));
    expect($configuration)->toBeInstanceOf(Configuration::class);
    expect($configuration->httpheader)->toBeInstanceOf(Headers::class);
    expect($configuration->httpheader)->toHaveCount(2);
    expect($configuration->toArray())->toBeArray();
    expect($configuration->toArray())->toHaveCount(4);
    return $configuration;
});

test('add header', function (Configuration $configuration) {
    $configuration->addHeader('one_more_header', 'one_more_value');
    expect($configuration->httpheader)->toHaveCount(3);
    return $configuration;
})->depends('instantiation with params');

test('remove header', function (Configuration $configuration) {
    $configuration->removeHeader('one_more_header');
    expect($configuration->httpheader)->toHaveCount(2);
})->depends('add header');

test('add headers', function (Configuration $configuration) {
    $configuration->addHeaders(array(
        'one_more_header' => 'one_more_value',
        'two_more_header' => 'two_more_value'
    ));
    expect($configuration->httpheader)->toHaveCount(4);
    return $configuration;
})->depends('instantiation with params');

test('remove headers', function (Configuration $configuration) {
    $configuration->removeHeaders(array(
        'one_more_header',
        'two_more_header'
    ));
    expect($configuration->httpheader)->toHaveCount(2);
})->depends('add headers');

test('basic auth', function (Configuration $configuration) {
    $configuration->basicAuth('username', 'password');
    expect($configuration->toArray())->toHaveCount(5);
    expect($configuration->userpwd)->toEqual('username=password');
})->depends('instantiation with params');

test('set SSL certificate', function (Configuration $configuration) {
    $configuration->setSSLCertificate('/some/path/to/ssl.cert');
    expect($configuration->toArray())->toHaveCount(6);
    expect($configuration->sslcert)->toEqual('/some/path/to/ssl.cert');
})->depends('instantiation with params');

test('set CA certificates capath', function (Configuration $configuration) {
    $configuration->setCACertificates('/some/path/to/capath', 'capath');
    expect($configuration->toArray())->toHaveCount(8);
    expect($configuration->capath)->toEqual('/some/path/to/capath');
})->depends('instantiation with params');

test('set CA certificates cainfo', function (Configuration $configuration) {
    $configuration->setCACertificates('/some/path/to/cainfo', 'cainfo');
    expect($configuration->toArray())->toHaveCount(9);
    expect($configuration->cainfo)->toEqual('/some/path/to/cainfo');
})->depends('instantiation with params');

test('wrong set CA certificates', function (Configuration $configuration) {
    $configuration->setCACertificates('/some/path/to/wrong', 'wrong');
    expect($configuration->toArray())->toHaveCount(8);
})->throws(RestException::class)->depends('instantiation with params');
