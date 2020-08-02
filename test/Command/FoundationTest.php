<?php

namespace Riddlestone\Brokkr\Foundation6\Test\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\Command\Foundation;
use Riddlestone\Brokkr\Foundation6\Service\FoundationConfig;
use Riddlestone\Brokkr\Portals\PortalManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FoundationTest
 * @package Riddlestone\Brokkr\Foundation6\Test
 * @covers \Riddlestone\Brokkr\Foundation6\Command\Foundation
 */
class FoundationTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetFoundationConfigServiceException(): void
    {
        $foundation = new Foundation();
        $this->expectException(Exception::class);
        $foundation->getFoundationConfigService();
    }

    /**
     * @throws Exception
     */
    public function testSetAndGetFoundationConfigService(): void
    {
        $foundation = new Foundation();
        $configService = $this->createMock(FoundationConfig::class);
        $foundation->setFoundationConfigService($configService);
        $this->assertEquals($configService, $foundation->getFoundationConfigService());
    }

    /**
     * @throws Exception
     */
    public function testGetPortalManagerException(): void
    {
        $foundation = new Foundation();
        $this->expectException(Exception::class);
        $foundation->getPortalManager();
    }

    /**
     * @throws Exception
     */
    public function testSetAndGetPortalManager(): void
    {
        $foundation = new Foundation();
        $portalManager = $this->createMock(PortalManager::class);
        $foundation->setPortalManager($portalManager);
        $this->assertEquals($portalManager, $foundation->getPortalManager());
    }

    public function testSetAndGetModulePath()
    {
        $foundation = new Foundation();
        $this->assertEquals(realpath(__DIR__ . '/../../'), $foundation->getModulePath());

        $foundation->setModulePath('/modules');
        $this->assertEquals('/modules', $foundation->getModulePath());
    }
}
