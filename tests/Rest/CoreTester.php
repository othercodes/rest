<?php

namespace Tests\Rest;

use OtherCode\Rest\Core\Core;

/**
 * Class CoreTester
 * @package Tests\Rest
 */
class CoreTester extends Core
{

    public function returnCall($method, $url, $body = null)
    {
        return $this->call($method, $url, $body);
    }

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