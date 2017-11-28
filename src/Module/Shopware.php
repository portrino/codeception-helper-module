<?php
namespace Portrino\Codeception\Module;

/*
 * This file is part of the Codeception Helper Module project
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read
 * LICENSE file that was distributed with this source code.
 *
 */

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Codeception\Module\Asserts;
use Portrino\Codeception\Interfaces\Commands\ShopwareCommand;
use Portrino\Codeception\Module\Interfaces\CommandExecutorInterface;
use Portrino\Codeception\Module\Traits\CommandExecutorTrait;
use Portrino\Codeception\Factory\ProcessBuilderFactory;

/**
 * Class Shopware
 * @package Portrino\Codeception\Module
 */
class Shopware extends Module implements DependsOnModule, CommandExecutorInterface
{
    use CommandExecutorTrait;

    const EXIT_STATUS_SUCCESS = 0;
    const EXIT_STATUS_FAILED = 1;

    /**
     * @var array
     */
    protected $config = [
        'bin-dir' => '../../bin/',
        'process-timeout' => 3600,
        'process-idle-timeout' => 60
    ];

    /**
     * @var string
     */
    protected $dependencyMessage = '"Asserts" module is required.';

    /**
     * Module constructor.
     *
     * Requires module container (to provide access between modules of suite) and config.
     *
     * @param ModuleContainer $moduleContainer
     * @param null $config
     * @codeCoverageIgnore
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
        $this->processTimeout = (int)$this->config['process-timeout'];
        $this->processIdleTimeout = (int)$this->config['process-idle-timeout'];
        $this->processBuilderFactory = new ProcessBuilderFactory();
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function _depends()
    {
        return [Asserts::class => $this->dependencyMessage];
    }

    /**
     * @param Asserts $assert
     * @codeCoverageIgnore
     */
    public function _inject(Asserts $asserts)
    {
        $this->asserts = $asserts;
        $this->consolePath = sprintf('%s%s', $this->config['bin-dir'], 'console');
    }

    /**
     * @param string $plugin
     * @param string $key
     * @param string $value
     * @param int $shop
     */
    public function setPluginConfiguration($plugin, $key, $value, $shop = 1)
    {
        $arguments = [
            $plugin,
            $key,
            $value
        ];
        if ($shop > 1) {
            $arguments['shop'] = $shop;
        }
        $this->executeCommand(
            ShopwareCommand::PLUGIN_CONFIG_SET,
            $arguments
        );
    }

    /**
     * clear cache
     */
    public function clearCache()
    {
        $this->executeCommand(
            ShopwareCommand::CACHE_CLEAR
        );
    }

    /**
     * regenerate theme cache
     */
    public function regenerateThemeCache()
    {
        $this->executeCommand(
            ShopwareCommand::CACHE_THEME_GENERATE
        );
    }

    /**
     * refresh plugin list
     */
    public function refreshPluginList()
    {
        $this->executeCommand(
            ShopwareCommand::PLUGIN_LIST_REFRESH
        );
    }

    /**
     * @param string $plugin
     */
    public function activatePlugin($plugin)
    {
        $this->executeCommand(
            ShopwareCommand::PLUGIN_ACTIVATE,
            [
                $plugin
            ]
        );
    }

    /**
     * @param string $plugin
     * @param bool $activate
     */
    public function installPlugin($plugin, $activate = false)
    {
        $arguments = [
            $plugin
        ];
        if ($activate) {
            $arguments['activate'] = '';
        }

        $this->executeCommand(
            ShopwareCommand::PLUGIN_INSTALL,
            $arguments
        );
    }

    /**
     * @param string $sql
     */
    public function runSqlCommand($sql)
    {
        $this->executeCommand(
            ShopwareCommand::RUN_SQL_COMMAND,
            [
                $sql
            ]
        );
    }
}
