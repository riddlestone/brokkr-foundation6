<?php

namespace Riddlestone\Brokkr\Foundation6\Test;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\PortalConfigProvider;
use Riddlestone\Brokkr\Foundation6\PortalConfigProviderFactory;
use Riddlestone\Brokkr\Portals\PortalManager;
use stdClass;

/**
 * Class PortalConfigProviderFactoryTest
 * @package Riddlestone\Brokkr\Foundation6\Test
 * @covers \Riddlestone\Brokkr\Foundation6\PortalConfigProviderFactory
 */
class PortalConfigProviderFactoryTest extends TestCase
{
    /**
     * @throws ContainerException
     */
    public function testInvoke()
    {
        $factory = new PortalConfigProviderFactory();

        $portalManager = $this->createMock(PortalManager::class);
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with(PortalManager::class)->willReturn($portalManager);

        $this->assertInstanceOf(PortalConfigProvider::class, $factory($container, PortalConfigProvider::class));

        $this->expectException(ServiceNotCreatedException::class);
        $factory($container, stdClass::class);
    }
}
