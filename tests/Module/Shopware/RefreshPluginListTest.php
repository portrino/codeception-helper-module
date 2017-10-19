<?php

namespace Portrino\Codeception\Tests\Module\Shopware;

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

use Codeception\Lib\ModuleContainer;
use Codeception\Module\Asserts;
use Portrino\Codeception\Factory\ProcessBuilderFactory;
use Portrino\Codeception\Interfaces\Commands\ShopwareCommand;
use Portrino\Codeception\Module\Shopware;
use Portrino\Codeception\Tests\Module\ShopwareTest;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class RefreshPluginListTest
 * @package Portrino\Codeception\Tests\Module\Shopware
 */
class RefreshPluginListTest extends ShopwareTest
{
    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->container = $this->prophesize(ModuleContainer::class);
        $this->process = $this->prophesize(Process::class);
        $this->processBuilderFactory = $this->prophesize(ProcessBuilderFactory::class);
        $this->builder = $this->prophesize(ProcessBuilder::class);
        $this->asserts = $this->prophesize(Asserts::class);

        $tmpBuilder = new ProcessBuilder();
        $cmd = $tmpBuilder
            ->setPrefix(self::$shopwareConsolePath)
            ->setArguments(
                [
                    ShopwareCommand::PLUGIN_LIST_REFRESH
                ]
            )
            ->getProcess()
            ->getCommandLine();

        $this->process->getCommandLine()->willReturn($cmd);
        $this->process->run()->shouldBeCalledTimes(1);

        $this->builder->setPrefix(self::$shopwareConsolePath)->shouldBeCalled();
        $this->builder
            ->setArguments(
                [
                    ShopwareCommand::PLUGIN_LIST_REFRESH
                ]
            )
            ->shouldBeCalled();

        $this->builder->getProcess()->willReturn($this->process);

        $this->process->isSuccessful()->willReturn(true);
        $this->process->getOutput()->willReturn(self::DEBUG_SUCCESS);
        $this->asserts->assertTrue(true)->shouldBeCalled();

        $this->processBuilderFactory->getBuilder()->willReturn($this->builder);

        $this->shopware = new Shopware($this->container->reveal());
        $this->shopware->setProcessBuilderFactory($this->processBuilderFactory->reveal());
        $this->shopware->_inject($this->asserts->reveal());
    }

    /**
     * @test
     */
    public function refreshPluginList()
    {
        $this->shopware->refreshPluginList();
    }
}
