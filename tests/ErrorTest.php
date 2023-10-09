<?php

use OtherCode\Rest\Core\Error;

test('instantiation default', function () {
    $error = new Error();
    expect($error->code)->toEqual(0);
    expect($error->message)->toEqual('none');
    expect($error->hasError())->toBeFalse();
    expect($error->__toString())->toBeString();
});

test('instantiation sample', function () {
    $error = new Error(500, "Something has exploded");
    expect($error->code)->toEqual(500);
    expect($error->message)->toEqual("Something has exploded");
    expect($error->hasError())->toBeTrue();
    expect($error->__toString())->toBeString();
});
