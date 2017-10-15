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

    public function testSetModule()
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
    public function testSetModuleFailed()
    {
        $http = new \OtherCode\Rest\Rest();
        $http->setModule('dummy', '\Tests\Modules\DummyNotExists');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetModuleInvalidHookName()
    {
        $http = new \OtherCode\Rest\Rest();
        $http->setModule('dummy', '\Tests\Modules\Dummy', 'notexisthook');
    }

    public function testCoreRegisterUnRegisterModule()
    {
        $core = new \Tests\Rest\CoreTester();

        $this->assertTrue($core->returnRegisterModule('dummy', 'after'));
        $this->assertFalse($core->returnRegisterModule('dummy', 'wrong'));
        $this->assertFalse($core->returnRegisterModule('dummy', 'after'));

        $this->assertTrue($core->returnUnRegisterModule('dummy', 'after'));
        $this->assertFalse($core->returnUnRegisterModule('dummy', 'wrong'));
        $this->assertFalse($core->returnUnRegisterModule('dummy', 'after'));
    }


    public function testRunModuleOnResponse()
    {
        $dummy = new \Tests\Modules\Dummy(new \OtherCode\Rest\Payloads\Response());
        $this->assertInstanceOf('\OtherCode\Rest\Payloads\Response', $dummy->output());
        $this->assertNull($dummy->run());
    }
}