<?php

namespace Tests\Rest;

/**
 * Class CoreTester
 * @package Tests\Rest
 */
class CoreTester extends \OtherCode\Rest\Core\Core
{
    /**
     * Register a new module.
     * @return bool
     */
    public function returnRegisterModule($name, $hook)
    {
        return $this->registerModule($name, new \Tests\Modules\Dummy($this->response), $hook);
    }

    /**
     * Un register a module
     * @return bool
     */
    public function returnUnRegisterModule($name, $hook)
    {
        return $this->unregisterModule($name, $hook);
    }

}