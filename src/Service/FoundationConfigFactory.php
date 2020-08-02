<?php

namespace Riddlestone\Brokkr\Foundation6\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Riddlestone\Brokkr\Portals\PortalManager;

class FoundationConfigFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new $requestedName();
        if (!($service instanceof FoundationConfig)) {
            throw new ServiceNotCreatedException($requestedName . ' is not an instance of ' . FoundationConfig::class);
        }
        $service->setConfig($container->get('Config')['foundation']);
        $service->setPortalManager($container->get(PortalManager::class));
        return $service;
    }
}
