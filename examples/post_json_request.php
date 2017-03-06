<?php

require_once '../autoload.php';

try {

    $api = new \OtherCode\Rest\Rest();
    $api->configuration->url = "http://jsonplaceholder.typicode.com/";
    $api->configuration->addHeader('some_header', 'some_value');

    $api->setEncoder("json");
    $api->setDecoder("json");

    $payload = new stdClass();
    $payload->userId = 3400;
    $payload->title = "Some title";
    $payload->body = "Some test data";

    $response = $api->post("posts/", $payload);
    var_dump($response);

} catch (\Exception $e) {

    print $e->getMessage();

}
