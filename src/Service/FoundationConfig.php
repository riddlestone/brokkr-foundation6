<?php

namespace Riddlestone\Brokkr\Foundation6\Service;

use Exception;
use Laminas\Config\Config;
use Riddlestone\Brokkr\Portals\PortalManager;

class FoundationConfig
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var PortalManager
     */
    protected $portalManager;

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getConfig(): array
    {
        if (empty($this->config)) {
            throw new Exception('Config not set');
        }
        return $this->config;
    }

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
        if (!$this->portalManager) {
            throw new Exception('Portal manager not set');
        }
        return $this->portalManager;
    }

    /**
     * @param string $portalName
     * @return array
     * @throws Exception
     */
    public function getFoundationConfig(string $portalName): array
    {
        // get the defaults
        $config = new Config($this->getConfig());

        // merge foundation settings for portal
        $config->merge(new Config($this->getPortalManager()->getPortalConfig($portalName, 'foundation')));

        // return the merged config
        return $config->toArray();
    }
}
