<?php

require_once '../autoload.php';

try {

    $api = new \OtherCode\Rest\Rest(new \OtherCode\Rest\Core\Configuration(array(
        'url' => 'http://jsonplaceholder.typicode.com/',
    )));
    $api->setDecoder("json");

    $response = $api->get("posts/1");
    var_dump($response);

} catch (\Exception $e) {

    print $e->getMessage();

}

