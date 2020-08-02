<?php

namespace Riddlestone\Brokkr\Foundation6;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Riddlestone\Brokkr\Portals\PortalManager;

class PortalConfigProviderFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $provider = new $requestedName();
        if (! $provider instanceof PortalConfigProvider) {
            throw new ServiceNotCreatedException($requestedName . ' not an instance of ' . PortalConfigProvider::class);
        }
        $provider->setPortalManager($container->get(PortalManager::class));
        return $provider;
    }
}
