<?php

namespace Riddlestone\Brokkr\Foundation6\Test;

use PHPUnit\Framework\TestCase;
use Riddlestone\Brokkr\Foundation6\JavaScriptMapper;

/**
 * Class JavaScriptMapperTest
 * @package Riddlestone\Brokkr\Foundation6\Test
 * @covers \Riddlestone\Brokkr\Foundation6\JavaScriptMapper
 */
class JavaScriptMapperTest extends TestCase
{
    public function testPluginPath()
    {
        $mapper = new JavaScriptMapper();

        $this->assertEquals(
            'vendor/zurb/foundation/dist/js/plugins',
            $mapper->getPluginPath()
        );
        $this->assertEquals(
            'vendor/zurb/foundation/dist/js/plugins/foundation.some.module.js',
            $mapper->applyPluginPath('some.module')
        );

        $mapper->setPluginPath('different/plugin/path');
        $this->assertEquals(
            'different/plugin/path',
            $mapper->getPluginPath()
        );
        $this->assertEquals(
            'different/plugin/path/foundation.some.module.js',
            $mapper->applyPluginPath('some.module')
        );

        $mapper->setPluginPath('different/plugin/path/');
        $this->assertEquals(
            'different/plugin/path',
            $mapper->getPluginPath()
        );

        $mapper->setPluginPath('/different/plugin/path');
        $this->assertEquals(
            '/different/plugin/path',
            $mapper->getPluginPath()
        );

        $mapper->setPluginPath('/different/plugin/path/');
        $this->assertEquals(
            '/different/plugin/path',
            $mapper->getPluginPath()
        );
    }

    public function testJQueryPath()
    {
        $mapper = new JavaScriptMapper();

        $this->assertEquals(
            'vendor/components/jquery/jquery.js',
            $mapper->getJqueryPath()
        );

        $mapper->setJqueryPath('some/path/jquery.min.js');
        $this->assertEquals(
            'some/path/jquery.min.js',
            $mapper->getJqueryPath()
        );
    }

    public function invokeData()
    {
        return [
            [
                'plugin_path' => 'plugins',
                'jquery_path' => 'jquery/jquery.js',
                'components' => [],
                'files' => [],
            ],
            [
                'plugin_path' => 'plugins',
                'jquery_path' => 'jquery/jquery.js',
                'components' => ['slider'],
                'files' => [
                    'jquery/jquery.js',
                    'plugins/foundation.core.js',
                    'plugins/foundation.util.keyboard.js',
                    'plugins/foundation.util.motion.js',
                    'plugins/foundation.util.touch.js',
                    'plugins/foundation.util.triggers.js',
                    'plugins/foundation.slider.js',
                ],
            ],
            [
                'plugin_path' => 'plugins',
                'jquery_path' => 'jquery/jquery.js',
                'components' => ['slider', 'dropdown_menu'],
                'files' => [
                    'jquery/jquery.js',
                    'plugins/foundation.core.js',
                    'plugins/foundation.util.keyboard.js',
                    'plugins/foundation.util.motion.js',
                    'plugins/foundation.util.touch.js',
                    'plugins/foundation.util.triggers.js',
                    'plugins/foundation.slider.js',
                    'plugins/foundation.util.box.js',
                    'plugins/foundation.util.nest.js',
                    'plugins/foundation.dropdownMenu.js',
                ],
            ],
        ];
    }

    /**
     * @dataProvider invokeData
     */
    public function testInvoke($pluginPath, $jqueryPath, $components, $files)
    {
        $mapper = new JavaScriptMapper();
        $mapper->setPluginPath($pluginPath);
        $mapper->setJqueryPath($jqueryPath);
        $this->assertEquals($files, $mapper($components));
    }
}
