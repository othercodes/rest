<?php

use OtherCode\Rest\Exceptions\ModuleNotFoundException;
use OtherCode\Rest\Payloads\Response;
use OtherCode\Rest\Rest;
use Tests\Modules\Dummy;
use Tests\Rest\CoreTester;
use Tests\Modules\DummyNotExist;

test('get modules', function () {
    $http = new Rest();
    expect($http->getModules())->toBeArray();
    expect($http->getModules())->toHaveCount(2);
    expect($http->getModules('before'))->toHaveCount(0);
    expect($http->getModules('after'))->toHaveCount(0);
});

test('set module', function () {
    $http = new Rest();

    $http->setModule('dummy', '\Tests\Modules\Dummy', 'after');
    expect($http->getModules('after'))->toHaveCount(1);

    $http->unsetModule('dummy', 'after');
    expect($http->getModules('after'))->toHaveCount(0);

    $http->setModule('dummy', '\Tests\Modules\Dummy', 'before');
    expect($http->getModules('before'))->toHaveCount(1);

    $http->unsetModule('dummy', 'before');
    expect($http->getModules('before'))->toHaveCount(0);
});

test('set module failed', function () {
    $http = new Rest();
    $http->setModule('dummy', DummyNotExists::class);
})->throws(ModuleNotFoundException::class);

test('set module invalid hook name', function () {
    $http = new Rest();
    $http->setModule('dummy', Dummy::class, 'notexisthook');
})->throws(InvalidArgumentException::class);

test('core register un register module', function () {
    $core = new CoreTester();

    expect($core->returnRegisterModule('dummy', 'after'))->toBeTrue();
    expect($core->returnRegisterModule('dummy', 'wrong'))->toBeFalse();
    expect($core->returnRegisterModule('dummy', 'after'))->toBeFalse();
    expect($core->returnUnRegisterModule('dummy', 'after'))->toBeTrue();
    expect($core->returnUnRegisterModule('dummy', 'wrong'))->toBeFalse();
    expect($core->returnUnRegisterModule('dummy', 'after'))->toBeFalse();
});

test('run module on response', function () {
    $dummy = new Dummy(new Response());
    expect($dummy->output())->toBeInstanceOf(OtherCode\Rest\Payloads\Response::class);
    expect($dummy->run())->toBeNull();
});
