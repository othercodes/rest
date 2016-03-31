<?php

require_once '../autoload.php';

$api = new OtherCode\Rest\Rest();
$api->configuration->url = "http://www.thomas-bayer.com/";
$api->configure();

$api->setDecoder("xml");

$response = $api->get("sqlrest/CUSTOMER/22");

if ($api->getError()->hasError() !== 0) {
    echo $api->getError()->message;
}
var_dump($response);