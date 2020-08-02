<?php

namespace Riddlestone\Brokkr\Foundation6;

class JavaScriptMapper
{
    /**
     * Path to Foundation's JavaScript plugin files
     *
     * @var string
     */
    protected $pluginPath = 'vendor/zurb/foundation/dist/js/plugins';

    /**
     * Path to compiled jQuery JavaScript file
     *
     * @var string
     */
    protected $jqueryPath = 'vendor/components/jquery/jquery.js';

    /**
     * Map from Foundation components to required Foundation JavaScript plugins
     *
     * @var array
     */
    protected $map = [
        'slider' => [
            'util.keyboard',
            'util.motion',
            'util.touch',
            'util.triggers',
            'slider',
        ],
        'dropdown_menu' => [
            'util.box',
            'util.keyboard',
            'util.nest',
            'util.touch',
            'dropdownMenu',
        ],
        'drilldown_menu' => [
            'util.box',
            'util.keyboard',
            'util.nest',
            'drilldown',
        ],
        'accordion_menu' => [
            'util.keyboard',
            'util.nest',
            'accordionMenu',
        ],
        'magellan' => [
            'util.triggers',
            'smoothScroll',
            'magellan',
        ],
        'accordion' => [
            'util.keyboard',
            'accordion',
        ],
        'dropdown' => [
            'util.box',
            'util.keyboard',
            'util.touch',
            'util.triggers',
            'dropdown',
        ],
        'off_canvas' => [
            'util.keyboard',
            'util.mediaQuery',
            'util.triggers',
            'offcanvas',
        ],
        'reveal' => [
            'util.keyboard',
            'util.mediaQuery',
            'util.motion',
            'util.touch',
            'util.triggers',
            'reveal',
        ],
        'tabs' => [
            'util.imageLoader',
            'util.keyboard',
            'tabs',
        ],
        'responsive_accordion_tabs' => [
            'util.imageLoader',
            'util.keyboard',
            'util.motion',
            'accordion',
            'tabs',
            'responsiveAccordionTabs',
        ],
        'orbit' => [
            'util.keyboard',
            'util.motion',
            'util.timer',
            'util.imageLoader',
            'util.touch',
            'orbit',
        ],
        'tooltip' => [
            'util.box',
            'util.mediaQuery',
            'util.triggers',
            'tooltip',
        ],
        'abide' => [
            'abide',
        ],
        'equalizer' => [
            'util.mediaQuery',
            'util.imageLoader',
            'equalizer',
        ],
        'interchange' => [
            'util.mediaQuery',
            'interchange',
        ],
        'toggler' => [
            'util.motion',
            'util.triggers',
            'toggler',
        ],
        'smoothscroll' => [
            'smoothScroll',
        ],
        'sticky' => [
            'util.triggers',
            'util.mediaQuery',
            'sticky',
        ],
    ];

    /**
     * Sets the directory path for Foundation's JavaScript plugin files
     *
     * @param string $pluginPath
     */
    public function setPluginPath(string $pluginPath): void
    {
        $this->pluginPath = rtrim($pluginPath, '/');
    }

    /**
     * Returns the directory path for Foundation's JavaScript plugin files
     *
     * @return string
     */
    public function getPluginPath(): string
    {
        return $this->pluginPath;
    }

    /**
     * Sets the file path for jQuery's JavaScript file
     *
     * @param string $jqueryPath
     */
    public function setJqueryPath(string $jqueryPath): void
    {
        $this->jqueryPath = $jqueryPath;
    }

    /**
     * Returns the file path for jQuery's JavaScript file
     *
     * @return string
     */
    public function getJqueryPath(): string
    {
        return $this->jqueryPath;
    }

    /**
     * Returns an array of required JavaScript files for the given Foundation components
     *
     * @param string[] $foundationModules
     * @return array
     */
    public function __invoke(array $foundationModules): array
    {
        $includes = [];
        foreach ($foundationModules as $module) {
            if (isset($this->map[$module])) {
                $includes = array_unique(array_merge($includes, $this->map[$module]));
            }
        }
        if ($includes) {
            array_unshift($includes, 'core');
            return array_merge(
                [$this->getJqueryPath()],
                array_map([$this, 'applyPluginPath'], $includes)
            );
        }
        return $includes;
    }

    /**
     * Provides the path
     *
     * @param string $plugin
     * @return string
     */
    public function applyPluginPath(string $plugin): string
    {
        return sprintf(
            '%s/foundation.%s.js',
            $this->pluginPath,
            $plugin
        );
    }
}
