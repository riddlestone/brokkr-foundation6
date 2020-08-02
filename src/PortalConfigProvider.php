<?php

namespace Riddlestone\Brokkr\Foundation6;

use Exception;
use Riddlestone\Brokkr\Portals\ConfigProviderInterface;
use Riddlestone\Brokkr\Portals\PortalManager;

class PortalConfigProvider implements ConfigProviderInterface
{
    /**
     * @var PortalManager
     */
    protected $portalManager;

    /**
     * @var JavaScriptMapper
     */
    protected $javaScriptMapper;

    /**
     * @param PortalManager $portalManager
     */
    public function setPortalManager(PortalManager $portalManager): void
    {
        $this->portalManager = $portalManager;
    }

    /**
     * @return PortalManager
     * @throws Exception
     */
    public function getPortalManager(): PortalManager
    {
        if ($this->portalManager === null) {
            throw new Exception('Portal Manager not set');
        }
        return $this->portalManager;
    }

    /**
     * @param JavaScriptMapper $javaScriptMapper
     */
    public function setJavaScriptMapper(JavaScriptMapper $javaScriptMapper): void
    {
        $this->javaScriptMapper = $javaScriptMapper;
    }

    /**
     * @return JavaScriptMapper
     */
    public function getJavaScriptMapper(): JavaScriptMapper
    {
        if (!$this->javaScriptMapper) {
            $this->javaScriptMapper = new JavaScriptMapper();
        }
        return $this->javaScriptMapper;
    }

    /**
     * @inheritDoc
     */
    public function getPortalNames(): array
    {
        // no new portals
        return [];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function hasConfiguration(string $portalName, ?string $configKey = null): bool
    {
        if ($configKey && !in_array($configKey, ['css', 'js'])) {
            return false;
        }
        return $this->getPortalManager()->hasPortalConfig($portalName, 'foundation');
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getConfiguration(string $portalName, ?string $configKey = null)
    {
        if (!$this->getPortalManager()->hasPortalConfig($portalName, 'foundation')) {
            return [];
        }
        $modules = array_keys(array_filter(
            $this->getPortalManager()->getPortalConfig($portalName, 'foundation')['modules']
        ));
        $data = [
            'css' => [
                sprintf('data/foundation/%s.scss', $portalName),
//                'vendor/zurb/foundation/dist/css/foundation.css',
            ],
            'js' => $this->getJavaScriptMapper()($modules),
        ];
        if ($configKey === null) {
            return $data;
        }
        if (isset($data[$configKey])) {
            return $data[$configKey];
        }
        return [];
    }
}
