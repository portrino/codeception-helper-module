<?php

namespace Portrino\Codeception\Tests\Module\Typo3;

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
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Portrino\Codeception\Module\Typo3;
use Portrino\Codeception\Tests\Module\Typo3Test;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Typo3FlushCacheTest
 *
 * @package Portrino\Codeception\Tests\Module\Typo3
 */
class FlushCacheTest extends Typo3Test
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
            ->setPrefix(self::$typo3cmsPath)
            ->setArguments(
                [
                    Typo3Command::CACHE_FLUSH,
                    'force' => '1',
                    'files-only' => '1'
                ]
            )
            ->getProcess()
            ->getCommandLine();

        $this->process->getCommandLine()->willReturn($cmd);
        $this->process->run()->shouldBeCalledTimes(1);

        $this->builder->setPrefix(self::$typo3cmsPath)->shouldBeCalled();
        $this->builder
            ->setArguments([
                Typo3Command::CACHE_FLUSH,
                'force' => true,
                'files-only' => true
            ])
            ->shouldBeCalled();

        $this->builder->getProcess()->willReturn($this->process);

        $this->process->isSuccessful()->willReturn(true);
        $this->process->getOutput()->willReturn(self::DEBUG_SUCCESS);
        $this->asserts->assertTrue(true)->shouldBeCalled();

        $this->processBuilderFactory->getBuilder()->willReturn($this->builder);

        $this->typo3 = new Typo3($this->container->reveal());
        $this->typo3->setProcessBuilderFactory($this->processBuilderFactory->reveal());
        $this->typo3->_inject($this->asserts->reveal());
    }

    /**
     * @test
     */
    public function flushCacheSuccessfully()
    {
        $this->typo3->flushCache(true, true);
    }
}
