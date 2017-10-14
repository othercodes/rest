<?php


class ModulesTest extends \PHPUnit\Framework\TestCase
{

    public function testGetModules()
    {
        $http = new \OtherCode\Rest\Rest();
        $this->assertInternalType('array', $http->getModules());
        $this->assertCount(2, $http->getModules());

        $this->assertCount(0, $http->getModules('before'));
        $this->assertCount(0, $http->getModules('after'));
    }

    public function testRegisterModule()
    {
        $http = new \OtherCode\Rest\Rest();

        $http->setModule('dummy', '\Tests\Modules\Dummy', 'after');
        $this->assertCount(1, $http->getModules('after'));

        $http->unsetModule('dummy', 'after');
        $this->assertCount(0, $http->getModules('after'));

        $http->setModule('dummy', '\Tests\Modules\Dummy', 'before');
        $this->assertCount(1, $http->getModules('before'));

        $http->unsetModule('dummy', 'before');
        $this->assertCount(0, $http->getModules('before'));
    }

    /**
     * @expectedException \OtherCode\Rest\Exceptions\ModuleNotFoundException
     */
    public function testFailLoadSetModule()
    {
        $http = new \OtherCode\Rest\Rest();
        $http->setModule('dummy', '\Tests\Modules\DummyNotExists');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidHookName()
    {
        $http = new \OtherCode\Rest\Rest();
        $http->setModule('dummy', '\Tests\Modules\Dummy', 'notexisthook');
    }
}