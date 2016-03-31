<?php

require_once '../autoload.php';

$api = new OtherCode\Rest\Rest();
$api->configuration->url = "http://jsonplaceholder.typicode.com/";
$api->configure();

$api->setDecoder("json");

$response = $api->get("posts/1");

if ($api->getError()->hasError() !== 0) {
    echo $api->getError()->message;
}
var_dump($response);