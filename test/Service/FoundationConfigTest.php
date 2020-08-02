<?php

namespace Riddlestone\Brokkr\Foundation6\Test\Service;

use Exception;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\Service\FoundationConfig;
use Riddlestone\Brokkr\Portals\PortalManager;

class FoundationConfigTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetConfigException(): void
    {
        $foundation = new FoundationConfig();
        $this->expectException(Exception::class);
        $foundation->getConfig();
    }

    /**
     * @throws Exception
     */
    public function testSetAndGetConfig(): void
    {
        $foundation = new FoundationConfig();
        $config = ['config' => true];
        $foundation->setConfig($config);
        $this->assertEquals($config, $foundation->getConfig());
    }

    /**
     * @throws Exception
     */
    public function testGetPortalManagerException(): void
    {
        $foundation = new FoundationConfig();
        $this->expectException(Exception::class);
        $foundation->getPortalManager();
    }

    /**
     * @throws Exception
     */
    public function testSetAndGetPortalManager(): void
    {
        $foundation = new FoundationConfig();
        $portalManager = $this->createMock(PortalManager::class);
        $foundation->setPortalManager($portalManager);
        $this->assertEquals($portalManager, $foundation->getPortalManager());
    }

    public function getFoundationConfigData(): array
    {
        return [
            [
                'config' => [
                    'enabled' => false,
                ],
                'portalConfig' => [],
                'combined' => [
                    'enabled' => false,
                ],
            ],
            [
                'config' => [
                    'enabled' => false,
                    'modules' => [
                        'tabs' => false,
                        'slider' => false,
                    ],
                ],
                'portalConfig' => [
                    'enabled' => true,
                    'modules' => [
                        'tabs' => true,
                    ],
                ],
                'combined' => [
                    'enabled' => true,
                    'modules' => [
                        'tabs' => true,
                        'slider' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider getFoundationConfigData
     * @param array $config
     * @param array $portalConfig
     * @param array $expected
     * @throws Exception
     */
    public function testGetFoundationConfig(array $config, array $portalConfig, array $expected): void
    {
        $portalManager = $this->createMock(PortalManager::class);
        $portalManager->method('getPortalConfig')
            ->with('main', 'foundation')
            ->willReturn($portalConfig);

        $foundationConfig = new FoundationConfig();
        $foundationConfig->setConfig($config);
        $foundationConfig->setPortalManager($portalManager);
        $this->assertEquals($expected, $foundationConfig->getFoundationConfig('main'));
    }
}
