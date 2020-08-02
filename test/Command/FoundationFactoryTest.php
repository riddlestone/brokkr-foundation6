<?php

namespace Riddlestone\Brokkr\Foundation6\Test\Command;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\Command\Foundation;
use Riddlestone\Brokkr\Foundation6\Command\FoundationFactory;
use Riddlestone\Brokkr\Foundation6\Service\FoundationConfig;
use Riddlestone\Brokkr\Portals\PortalManager;
use stdClass;

/**
 * Class FoundationFactoryTest
 * @package Riddlestone\Brokkr\Foundation6\Test\Command
 * @covers \Riddlestone\Brokkr\Foundation6\Command\FoundationFactory
 */
class FoundationFactoryTest extends TestCase
{
    /**
     * @throws ContainerException
     */
    public function testInvoke()
    {
        $factory = new FoundationFactory();

        $portalManager = $this->createMock(PortalManager::class);
        $configService = $this->createMock(FoundationConfig::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->willReturnCallback(
            function ($name) use ($configService, $portalManager) {
                if ($name === FoundationConfig::class) {
                    return $configService;
                }
                if ($name === PortalManager::class) {
                    return $portalManager;
                }
                throw new ServiceNotFoundException();
            }
        );

        $this->assertInstanceOf(Foundation::class, $factory($container, Foundation::class));

        $this->expectException(ServiceNotCreatedException::class);
        $factory($container, stdClass::class);
    }
}
