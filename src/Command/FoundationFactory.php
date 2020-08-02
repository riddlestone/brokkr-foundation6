<?php

namespace Riddlestone\Brokkr\Foundation6\Command;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Riddlestone\Brokkr\Foundation6\Service\FoundationConfig;
use Riddlestone\Brokkr\Portals\PortalManager;

class FoundationFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $command = new $requestedName();
        if (!($command instanceof Foundation)) {
            throw new ServiceNotCreatedException($requestedName . ' is not an instance of ' . Foundation::class);
        }
        $command->setFoundationConfigService($container->get(FoundationConfig::class));
        $command->setPortalManager($container->get(PortalManager::class));
        return $command;
    }
}
