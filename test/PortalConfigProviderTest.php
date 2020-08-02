<?php

namespace Riddlestone\Brokkr\Foundation6\Test;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\JavaScriptMapper;
use Riddlestone\Brokkr\Foundation6\PortalConfigProvider;
use Riddlestone\Brokkr\Portals\PortalManager;

/**
 * Class PortalConfigProviderTest
 * @package Riddlestone\Brokkr\Foundation6\Test
 * @covers \Riddlestone\Brokkr\Foundation6\PortalConfigProvider
 */
class PortalConfigProviderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetPortalManagerException()
    {
        $provider = new PortalConfigProvider();
        $this->expectException(Exception::class);
        $provider->getPortalManager();
    }

    /**
     * @throws Exception
     */
    public function testSetAndGetPortalManager()
    {
        $provider = new PortalConfigProvider();
        $portalManager = $this->createMock(PortalManager::class);
        $provider->setPortalManager($portalManager);
        $this->assertEquals($portalManager, $provider->getPortalManager());
    }

    public function testSetAndGetJavaScriptMapper()
    {
        $provider = new PortalConfigProvider();
        $this->assertInstanceOf(JavaScriptMapper::class, $provider->getJavaScriptMapper());

        $javaScriptMapper = $this->createMock(JavaScriptMapper::class);
        $provider->setJavaScriptMapper($javaScriptMapper);
        $this->assertEquals($javaScriptMapper, $provider->getJavaScriptMapper());
    }

    public function testGetPortals()
    {
        $provider = new PortalConfigProvider();
        $this->assertEquals([], $provider->getPortalNames());
    }

    public function configurationData()
    {
        return [
            [
                'portalConfig' => [],
                'portalName' => 'main',
                'has' => [
                    'css' => false,
                    'js' => false,
                    'other' => false,
                ],
                'get' => [
                    'css' => [],
                    'js' => [],
                    'other' => [],
                ],
            ],
            [
                'portalConfig' => [
                    'main' => [
                        'css' => [
                            'external_css.css',
                        ],
                    ],
                ],
                'portalName' => 'main',
                'has' => [
                    'css' => false,
                ],
                'get' => [
                    'css' => [],
                ],
            ],
            [
                'portalConfig' => [
                    'main' => [
                        'foundation' => [
                            'modules' => [
                                'tabs' => true,
                                'menus' => false,
                            ],
                        ],
                    ],
                ],
                'portalName' => 'main',
                'has' => [
                    'css' => true,
                    'js' => true,
                    null => true,
                    'other' => false,
                ],
                'get' => [
                    'css' => [
                        'data/foundation/main.scss',
                    ],
                    'js' => [
                        '/scripts/tabs.js',
                    ],
                    null => [
                        'css' => [
                            'data/foundation/main.scss',
                        ],
                        'js' => [
                            '/scripts/tabs.js',
                        ],
                    ],
                    'other' => [],
                ],
            ],
        ];
    }

    /**
     * @param $portalConfig
     * @return MockObject|PortalManager
     */
    protected function getPortalManagerMock($portalConfig)
    {
        $portalManager = $this->createMock(PortalManager::class);
        $portalManager->method('hasPortalConfig')->willReturnCallback(
            function ($portalName, $configKey) use ($portalConfig) {
                if (!array_key_exists($portalName, $portalConfig)) {
                    return false;
                }
                if ($configKey !== null && !array_key_exists($configKey, $portalConfig[$portalName])) {
                    return false;
                }
                return true;
            }
        );
        $portalManager->method('getPortalConfig')->willReturnCallback(
            function ($portalName, $configKey) use ($portalConfig) {
                if (!array_key_exists($portalName, $portalConfig)) {
                    return [];
                }
                if ($configKey === null) {
                    return $portalConfig[$portalName];
                }
                if (!array_key_exists($configKey, $portalConfig[$portalName])) {
                    return [];
                }
                return $portalConfig[$portalName][$configKey];
            }
        );
        return $portalManager;
    }

    /**
     * @return MockObject|JavaScriptMapper
     */
    protected function getJavaScriptMapperMock()
    {
        $javaScriptMapper = $this->createMock(JavaScriptMapper::class);
        $javaScriptMapper->method('__invoke')->willReturnCallback(
            function ($modules) {
                return array_map(function ($module) {
                    return '/scripts/' . $module . '.js';
                }, $modules);
            }
        );
        return $javaScriptMapper;
    }

    /**
     * @dataProvider configurationData
     * @throws Exception
     */
    public function testConfiguration($portalConfig, $portalName, $hasResults, $getResults)
    {
        $provider = new PortalConfigProvider();
        $provider->setPortalManager($this->getPortalManagerMock($portalConfig));
        $provider->setJavaScriptMapper($this->getJavaScriptMapperMock());

        foreach ($hasResults as $configKey => $expected) {
            if (!$configKey) {
                $configKey = null;
            }
            $this->assertEquals($expected, $provider->hasConfiguration($portalName, $configKey));
        }
        foreach ($getResults as $configKey => $expected) {
            if (!$configKey) {
                $configKey = null;
            }
            $this->assertEquals($expected, $provider->getConfiguration($portalName, $configKey));
        }
    }
}
