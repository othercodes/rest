<?php

require_once '../autoload.php';

try {

    $api = new \OtherCode\Rest\Rest();
    $api->configuration->url = "http://www.thomas-bayer.com/";
    $api->setDecoder("xml");

    $response = $api->get("sqlrest/CUSTOMER/22");
    var_dump($response);

} catch (\Exception $e) {

    print $e->getMessage();

}
