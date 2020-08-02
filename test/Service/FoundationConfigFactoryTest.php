<?php

namespace Riddlestone\Brokkr\Foundation6\Test\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\Service\FoundationConfig;
use Riddlestone\Brokkr\Foundation6\Service\FoundationConfigFactory;
use Riddlestone\Brokkr\Portals\PortalManager;
use stdClass;

/**
 * Class FoundationFactoryTest
 * @package Riddlestone\Brokkr\Foundation6\Test
 * @covers \Riddlestone\Brokkr\Foundation6\Service\FoundationConfigFactory
 */
class FoundationFactoryTest extends TestCase
{
    /**
     * @throws ContainerException
     */
    public function testInvoke()
    {
        $factory = new FoundationConfigFactory();

        $portalManager = $this->createMock(PortalManager::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturnCallback(
            function ($name) use ($portalManager) {
                if ($name === 'Config') {
                    return [
                        'foundation' => [],
                    ];
                }
                if ($name === PortalManager::class) {
                    return $portalManager;
                }
                throw new ServiceNotFoundException();
            }
        );

        $this->assertInstanceOf(FoundationConfig::class, $factory($container, FoundationConfig::class));

        $this->expectException(ServiceNotCreatedException::class);
        $factory($container, stdClass::class);
    }
}
