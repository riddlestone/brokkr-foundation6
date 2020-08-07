<?php

namespace Riddlestone\Brokkr\Foundation6\Command;

use ArrayAccess;
use Exception;
use Riddlestone\Brokkr\Foundation6\Service\FoundationConfig;
use Riddlestone\Brokkr\Portals\PortalManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Foundation extends Command
{
    protected static $defaultName = 'foundation';

    /**
     * @var ?FoundationConfig
     */
    protected $configService;

    /**
     * @var ?PortalManager
     */
    protected $portalManager;

    /**
     * @var ?string
     */
    protected $modulePath;

    /**
     * @param FoundationConfig $configService
     */
    public function setFoundationConfigService(FoundationConfig $configService): void
    {
        $this->configService = $configService;
    }

    /**
     * @return FoundationConfig
     * @throws Exception
     */
    public function getFoundationConfigService(): FoundationConfig
    {
        if (!$this->configService) {
            throw new Exception('Foundation Config Service not set');
        }
        return $this->configService;
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
     * @param string $modulePath
     */
    public function setModulePath(string $modulePath): void
    {
        $this->modulePath = $modulePath;
    }

    /**
     * Returns the path to this module relative to the application root
     *
     * @return string
     */
    public function getModulePath(): string
    {
        if ($this->modulePath === null) {
            $this->modulePath = str_replace(getcwd() . '/', '', realpath(__DIR__ . '/../..'));
        }
        return $this->modulePath;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get all portals
        foreach ($this->getPortalManager()->getPortalNames() as $portalName) {
            $this->createPortalFiles($portalName);
        }
        return 0;
    }

    /**
     * @param string $portalName
     * @throws Exception
     */
    protected function createPortalFiles(string $portalName)
    {
        // get the defaults
        $config = $this->getFoundationConfigService()->getFoundationConfig($portalName);

        // check foundation is enabled
        if (empty($config['enabled'])) {
            return;
        }

        // create portal file
        if (!is_dir('data/foundation')) {
            mkdir('data/foundation');
        }
        file_put_contents(
            sprintf('data/foundation/%s.scss', $portalName),
            $this->createModuleVariables($config) . $this->createIncludes($config)
        );
    }

    /**
     * @param array|ArrayAccess $config
     * @return string
     */
    protected function createModuleVariables($config)
    {
        $modules = '';
        foreach ($config['modules'] as $module => $enabled) {
            $modules .= sprintf(
                "\$foundation-%s: %s;\n",
                str_replace('_', '-', $module),
                $enabled ? 'true' : 'false'
            );
        }
        return $modules;
    }

    /**
     * @param array|ArrayAccess $config
     * @return string
     */
    protected function createIncludes($config)
    {
        $modulePath = $this->getModulePath();
        $includes = "@import '$modulePath/scss/dependencies';\n";
        if (!empty($config['settings']) && is_string($config['settings'])) {
            $includes .= sprintf("@import '%s';\n", $config['settings']);
        }
        $includes .= "@import '$modulePath/scss/foundation';\n";
        if ($config['modules']['orbit']) {
            $includes .= "@import 'https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css';\n";
        }
        foreach ($config['extra_includes'] as $extraInclude) {
            $extraInclude = str_replace(getcwd() . '/', '', $extraInclude);
            $includes .= "@import '$extraInclude';\n";
        }
        return $includes;
    }
}
