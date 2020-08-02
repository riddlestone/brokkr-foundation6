<?php

namespace Riddlestone\Brokkr\Foundation6\Test;

use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\Module;

/**
 * Class ModuleTest
 * @package Riddlestone\Brokkr\Foundation6\Test
 * @covers \Riddlestone\Brokkr\Foundation6\Module
 */
class ModuleTest extends TestCase
{
    public function testGetConfig()
    {
        $module = new Module();
        $this->assertIsArray($module->getConfig());
        $this->assertArrayHasKey('foundation', $module->getConfig());
    }
}
