<?php

require_once '../autoload.php';

$api = new OtherCode\Rest\Rest();
$api->configuration->url = "http://jsonplaceholder.typicode.com/";
$api->configuration->addHeader('some_header', 'some_value');
$api->configure();

$api->setEncoder("json");
$api->setDecoder("json");

$payload = new stdClass();
$payload->userId = 3400;
$payload->title = "Some title";
$payload->body = "Some test data";

$response = $api->post("posts/", $payload);

if ($api->getError()->hasError() !== 0) {
    echo $api->getError()->message;
}
var_dump($response);